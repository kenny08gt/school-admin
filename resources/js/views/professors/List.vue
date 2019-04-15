<template>
  <div class="app-container">
    <el-table v-loading="professorsListLoading" :data="professorsList" border fit highlight-current-row style="width: 100%">
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
      <el-table-column align="left" :label="$t('common.course')+'s'">
        <template slot-scope="scope">
          <el-tag style="margin: 2px;" v-for="course in scope.row.courses" :key="course.id">{{ course.name }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column align="center" :label="$t('common.actions')">
        <template slot-scope="scope">
          <el-row>
            <el-button type="success" icon="el-icon-setting" circle @click="changePassword(scope.row)"></el-button>
            <el-button type="primary" icon="el-icon-edit" circle @click="editProfessor(scope.row)"></el-button>
            <el-button type="danger" icon="el-icon-delete" circle @click="deleteProfessorRequest(scope.row)"></el-button>
          </el-row>
        </template>
      </el-table-column>
    </el-table>
    <pagination v-show="total>0" :total="total" :page.sync="professorsListQuery.page" :limit.sync="professorsListQuery.limit" @pagination="getProfessorsList" />
    <edit-professor-modal ref="editProfessorModal" :courses="courses"></edit-professor-modal>
    <change-password-modal ref="changePasswordModal"></change-password-modal>
  </div>
</template>

<script>
import { fetchList, deleteProfessor } from '@/api/professors';
import { fetchList as fetchCoursesList } from '@/api/courses';
import Pagination from '@core/components/Pagination';
import Professor from '@/objects/professor';
import editProfessorModal from './modals/edit';
import changePasswordProfessorModal from './modals/change-password';
import Course from '../../objects/course';

export default {
  name: 'gradesList',
  components: {
    Pagination,
    'edit-professor-modal': editProfessorModal,
    'change-password-modal': changePasswordProfessorModal,
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
      professorsList: null,
      total: 0,
      courses: null,
      professorsListLoading: true,
      professorsListQuery: {
        page: 1,
        limit: 20,
      },
    };
  },
  created() {
    this.getProfessorsList();
    this.getCoursesList();
  },
  methods: {
    getProfessorsList() {
      this.professorsListLoading = true;
      fetchList(this.professorsListQuery).then(response => {
        this.professorsList = response.items.map(function(item, index) {
          return new Professor(item);
        });
        this.total = response.total;
        this.professorsListLoading = false;
      }).catch((error) => {
        console.log('error', error);
      });
    },
    getCoursesList() {
      this.professorsListLoading = true;
      fetchCoursesList().then(response => {
        this.courses = response.items.map(function(item, index) {
          return new Course(item);
        });
        this.professorsListLoading = false;
      }).catch((error) => {
        console.log('error', error);
      });
    },
    handleSizeChange(val) {
      this.professorsListQuery.limit = val;
      this.getProfessorsList();
    },
    handleCurrentChange(val) {
      this.professorsListQuery.page = val;
      this.getProfessorsList();
    },
    editProfessor(professor) {
      this.$refs.editProfessorModal.show(professor);
    },
    deleteProfessorRequest(professor) {
      this.$confirm(this.$t('common.delete-message'), 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: this.$t('common.cancel'),
        type: 'warning',
      }).then(() => {
        deleteProfessor(professor).then((data) => {
          const index = this.professorsList.indexOf(professor);
          this.professorsList.splice(index, 1);
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
    changePassword(professor) {
      this.$refs.changePasswordModal.show(professor);
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

