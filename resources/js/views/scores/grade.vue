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
        <template>
          <el-table-column align="left" :label="course.name" v-for="course in grade.courses" :key="course.id">
            <template slot-scope="scope">
              <input type="number" name="score" class="el-input__inner" v-model="scores.student[scope.row.id+'.'+course.id]" @input="debounceInput">
            </template>
          </el-table-column>
        </template>
      </el-table-column>
    </el-table>
    <el-row v-if="grade.id" style="margin-top: 10px; text-align: right;">
      <el-col :span="24">
        <el-button type="primary" @click="saveChanges">
          {{$t('common.save-changes')}}
        </el-button>
        <el-button @click="this.$router.back();">
          {{$t('common.back')}}
        </el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetch, fetchList as fetchGradesList } from '@/api/grades';
import { update as updateScores, fetch as fetchScores } from '@/api/scores';
import Student from '../../objects/student';
import Grade from '../../objects/grade';
import { debounce } from 'debounce';

export default {
  name: 'gradesList',
  components: {
  },
  data() {
    return {
      studentsList: null,
      total: 0,
      courses: null,
      current_course: {
        id: 0,
        name: '',
      },
      studentsLoading: false,
      scores: {
        grade_id: 0,
        student: {
          id: 0,
          score: 0,
        },
      },
      grades: [],
      grade: {
        courses: [],
      },
      studentsListQuery: {
        page: 1,
        limit: 20,
      },
      changes_saved: true,
    };
  },
  created() {
    this.getGradesList();
    this.$message({
      message: 'Changes need to be saved!',
      type: 'info',
      duration: this.changes_saved ? 1 : 0,
    });
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
      const $this = this;
      this.studentsLoading = true;
      fetch({ grade_id: this.grade.id }).then(response => {
        // console.log('response', response);
        this.grade = new Grade(response[0]);
        this.scores.grade_id = this.grade.id;
        this.scores.student = {};

        this.studentsList = this.grade.students.map(function(student, index) {
          return new Student(student);
        });
        $this.generateScoresList();
        this.studentsLoading = false;
      }).catch((error) => {
        console.log('error', error);
      });
    },
    generateScoresList(student) {
      const $this = this;
      fetchScores({ grade_id: $this.grade.id }).then(response => {
        console.log('response', response[0]);
        $this.scores = response[0];
        console.log('scores', $this.scores);
        if ($this.scores.length === 0) {
          $this.scores = JSON.parse(localStorage.getItem('scores.' + $this.grade.id));
        }
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
    debounceInput: debounce(function (e) {
      this.changes_saved = false;
      localStorage.setItem('scores.' + this.scores.grade_id, JSON.stringify(this.scores));
    }, 3000),
    saveChanges() {
      updateScores(this.scores).then(response => {
        this.$message('Success!');
        this.changes_saved = true;
        localStorage.removeItem('scores.' + this.scores.grade_id);
      }).catch((error) => {
        console.log('error', error);
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

