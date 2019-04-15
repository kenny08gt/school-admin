<template>
  <div class="app-container">
    <student-form :grades="grades" :student="student" :is_editing="is_editing" @on_submit="onSubmit" @on_cancel="onCancel" @on_newstudent="newStudent"></student-form>
    <el-row>
      <el-col :span="24">
        <el-button v-if="is_editing" @click="newStudent">New Student</el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { createStudent } from '../../api/students';
import { fetchList } from '../../api/grades';
import studentFrom from './components/student-form';
import Grade from '../../objects/grade';
export default {
  name: 'Add',
  data() {
    return {
      student: null,
      grades: null,
      is_editing: false,
    };
  },
  components: {
    'student-form': studentFrom,
  },
  created() {
    this.newStudent();
    this.getGradesList();
  },
  methods: {
    onSubmit() {
      createStudent(this.student).then(data => {
        this.student.id = data[0].id;
        this.is_editing = true;
        this.$message('Success!');
        // this.$router.push({ path: '/students/list' });
      }).catch((error) => {
        console.log('error', error);
        this.$message({
          message: 'cancel!',
          type: 'warning',
        });
      });
    },
    onCancel() {
      // this.$message({
      //   message: 'cancel!',
      //   type: 'warning',
      // });
      this.newStudent();
      this.$router.back();
    },
    getGradesList() {
      fetchList().then(response => {
        this.grades = response.items.map(function(item, index) {
          return new Grade(item);
        });
      }).catch((error) => {
        console.log('error', error);
      });
    },
    newStudent() {
      this.is_editing = false;
      this.student = {
        id: 0,
        name: '',
        picture: '',
        grade_id: null,
      };
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

