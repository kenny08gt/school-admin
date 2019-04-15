<template>
  <div class="app-container">
    <el-table v-loading="studentsListLoading" :data="studentsList" border fit highlight-current-row style="width: 100%">
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column align="left" :label="$t('common.name')">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column align="left" :label="$t('common.email')">
        <template slot-scope="scope">
          <span>{{ scope.row.email }}</span>
        </template>
      </el-table-column>
      <el-table-column align="left" :label="$t('common.created-at')">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at | moment("LL") }}</span>
        </template>
      </el-table-column>
      <el-table-column align="left" :label="$t('common.grade')+'s'">
        <template slot-scope="scope">
          <el-tag style="margin: 2px;" >{{ scope.row.grade.name }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column align="center" :label="$t('common.actions')">
        <template slot-scope="scope">
          <el-row>
            <el-button type="primary" icon="el-icon-edit" circle @click="editStudent(scope.row)"></el-button>
            <el-button type="danger" icon="el-icon-delete" circle @click="deleteProfessorRequest(scope.row)"></el-button>
          </el-row>
        </template>
      </el-table-column>
    </el-table>
    <pagination v-show="total>0" :total="total" :page.sync="studentsListQuery.page" :limit.sync="studentsListQuery.limit" @pagination="getStudentsList" />
    <edit-student-modal ref="editStudentModal" :grades="grades"></edit-student-modal>
  </div>
</template>

<script>
import { fetchList, deleteStudent } from '@/api/students';
import { fetchList as fetchGradesList } from '@/api/grades';
import Pagination from '@core/components/Pagination';
import Student from '@/objects/student';
import editStudentModal from './modals/edit';
import Grade from '../../objects/grade';

export default {
  name: 'gradesList',
  components: {
    Pagination,
    'edit-student-modal': editStudentModal,
  },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger',
      };
      return statusMap[status];
    },
  },
  data() {
    return {
      studentsList: null,
      total: 0,
      grades: null,
      studentsListLoading: true,
      studentsListQuery: {
        page: 1,
        limit: 20,
      },
    };
  },
  created() {
    this.getStudentsList();
    this.getGradesList();
  },
  methods: {
    getStudentsList() {
      this.studentsListLoading = true;
      fetchList(this.studentsListQuery).then(response => {
        this.studentsList = response.items.map(function(item, index) {
          return new Student(item);
        });
        this.total = response.total;
        this.studentsListLoading = false;
      }).catch((error) => {
        console.log('error', error);
      });
    },
    getGradesList() {
      this.studentsListLoading = true;
      fetchGradesList().then(response => {
        this.grades = response.items.map(function(item, index) {
          return new Grade(item);
        });
        this.studentsListLoading = false;
      }).catch((error) => {
        console.log('error', error);
      });
    },
    handleSizeChange(val) {
      this.studentsListQuery.limit = val;
      this.getStudentsList();
    },
    handleCurrentChange(val) {
      this.studentsListQuery.page = val;
      this.getStudentsList();
    },
    editStudent(student) {
      this.$refs.editStudentModal.show(student);
    },
    deleteProfessorRequest(student) {
      this.$confirm(this.$t('common.delete-message'), 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: this.$t('common.cancel'),
        type: 'warning',
      }).then(() => {
        deleteStudent(student).then((data) => {
          const index = this.studentsList.indexOf(student);
          this.studentsList.splice(index, 1);
          this.$message({
            type: 'success',
            message: 'Delete completed',
          });
        }).catch((error) => {
          console.log('error', error);
          this.$message({
            type: 'info',
            message: 'Something went wrong',
          });
        });
      });
    },
  },
};
</script>

<style scoped>
  .chart-container{
    position: relative;
    width: 100%;
    height: calc(100vh - 84px);
  }
</style>

