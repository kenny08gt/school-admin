<template>
  <div class="app-container">
    <el-table v-loading="courseListLoading" :data="courseList" border fit highlight-current-row style="width: 100%">
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
      <el-table-column align="left" :label="$t('common.description')">
        <template slot-scope="scope">
          <span>{{ scope.row.description }}</span>
        </template>
      </el-table-column>
      <el-table-column align="left" :label="$t('common.grade')">
        <template slot-scope="scope">
          <el-tag style="margin: 2px;" v-for="grade in scope.row.grades" :key="grade.id">{{ grade.name }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column align="left" :label="$t('common.created-at')">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at | moment("LL") }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" :label="$t('common.actions')">
        <template slot-scope="scope">
          <el-row>
            <el-button type="primary" icon="el-icon-edit" circle @click="editCourse(scope.row)"></el-button>
            <el-button type="danger" icon="el-icon-delete" circle @click="deleteCourseRequest(scope.row)"></el-button>
          </el-row>
        </template>
      </el-table-column>
    </el-table>
    <pagination v-show="total>0" :total="total" :page.sync="courseListQuery.page" :limit.sync="courseListQuery.limit" @pagination="getCourseList" />
    <edit-course-modal ref="editCourseModal" :grades="gradesList"></edit-course-modal>
  </div>
</template>

<script>
import { fetchList, deleteCourse } from '@/api/courses';
import { fetchList as fetchListGrades } from '@/api/grades';
import Pagination from '@core/components/Pagination';
import editModal from './modals/edit';
import Course from '@/objects/course';
import Grade from '@/objects/grade';

export default {
  name: 'coursesList',
  components: {
    Pagination,
    'edit-course-modal': editModal,
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
      courseList: null,
      gradesList: null,
      total: 0,
      courseListLoading: true,
      courseListQuery: {
        page: 1,
        limit: 20,
      },
    };
  },
  created() {
    this.getCourseList();
  },
  methods: {
    getCourseList() {
      this.courseListLoading = true;
      fetchList(this.courseListQuery).then(response => {
        this.courseList = response.items.map(function(item, index) {
          return new Course(item);
        });
        this.total = response.total;
        this.getGradeList();
      }).catch((error) => {
        console.log('error', error);
      });
    },
    getGradeList() {
      fetchListGrades().then(response => {
        this.gradesList = response.items.map(function(item, index) {
          return new Grade(item);
        });
        this.courseListLoading = false;
      }).catch((error) => {
        console.log('error', error);
      });
    },
    handleSizeChange(val) {
      this.courseListQuery.limit = val;
      this.getCourseList();
    },
    handleCurrentChange(val) {
      this.courseListQuery.page = val;
      this.getCourseList();
    },
    editCourse(course) {
      this.$refs.editCourseModal.show(course);
    },
    deleteCourseRequest(course) {
      this.$confirm(this.$t('common.delete-message'), 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        deleteCourse(course).then((data) => {
          const index = this.courseList.indexOf(course);
          this.courseList.splice(index, 1);
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

