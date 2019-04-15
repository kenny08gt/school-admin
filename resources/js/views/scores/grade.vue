<template>
  <div class="app-container">
    <label>Select a grade</label>
    <el-select v-model="grade.id" placeholder="Select" @change="getGradeInformation" style="margin-bottom: 5px;">
      <el-option
        v-for="grade in grades"
        :key="grade.id"
        :label="grade.name"
        :value="grade.id">
      </el-option>
    </el-select>
    <el-table v-loading="studentsLoading" :data="studentsList" border fit highlight-current-row style="width: 100%">
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
      <el-table-column align="left" label="Courses">
        <template >
            <el-table-column v-for="course in grade.courses" :key="course.id" :label="course.name">
              <template >
                <el-input-number :precision="2" :step="0.1" :max="100"></el-input-number>
              </template>
            </el-table-column>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { fetch, fetchList as fetchGradesList } from '@/api/grades';
import Student from '../../objects/student';
import Grade from '../../objects/grade';
export default {
  name: 'gradesList',
  components: {
  },
  data() {
    return {
      studentsList: null,
      total: 0,
      courses: null,
      studentsLoading: false,
      grades: [],
      grade: {
        courses: [],
      },
      studentsListQuery: {
        page: 1,
        limit: 20,
      },
    };
  },
  created() {
    this.getGradesList();
  },
  methods: {
    getGradesList() {
      fetchGradesList().then(response => {
        this.grades = response.items.map(function(item, index) {
          return new Grade(item);
        });
      }).catch((error) => {
        console.log('error', error);
      });
    },
    getGradeInformation() {
      this.studentsLoading = true;
      fetch({ grade_id: this.grade.id }).then(response => {
        // console.log('response', response);
        this.grade = new Grade(response[0]);

        this.studentsList = this.grade.students.map(function(item, index) {
          return new Student(item);
        });
        this.studentsLoading = false;
      }).catch((error) => {
        console.log('error', error);
      });
    },
    handleSizeChange(val) {
      this.studentsListQuery.limit = val;
      this.getProfessorsList();
    },
    handleCurrentChange(val) {
      this.studentsListQuery.page = val;
      this.getProfessorsList();
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

