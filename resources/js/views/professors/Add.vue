<template>
  <div class="app-container">
    <professor-form :courses="courses" :professor="professor" :is_editing="is_editing" @on_submit="onSubmit" @on_cancel="onCancel" @on_newprofessor="newProfessor"></professor-form>
    <el-row>
      <el-col :span="24">
        <el-button v-if="is_editing" @click="newProfessor">New Professor</el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { createProfessor } from '../../api/professors';
import { fetchList } from '../../api/courses';
import professorFrom from './components/professor-form';
import Course from '../../objects/course';
export default {
  name: 'Add',
  data() {
    return {
      professor: null,
      courses: null,
      is_editing: false,
    };
  },
  components: {
    'professor-form': professorFrom,
  },
  created() {
    this.newProfessor();
    this.getCoursesList();
  },
  methods: {
    onSubmit() {
      createProfessor(this.professor).then(data => {
        this.professor.id = data[0].id;
        this.is_editing = true;
        this.$message('Success!');
        // this.$router.push({ path: '/professors/list' });
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
      this.newProfessor();
      this.$router.back();
    },
    getCoursesList() {
      fetchList().then(response => {
        this.courses = response.items.map(function(item, index) {
          return new Course(item);
        });
      }).catch((error) => {
        console.log('error', error);
      });
    },
    newProfessor() {
      this.is_editing = false;
      this.professor = {
        id: 0,
        name: '',
        email: '',
        password: '',
        role: 'professor',
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

