<template>
  <div class="app-container">
    <grade-form :grade="grade" :is_editing="is_editing" @on_submit="onSubmit" @on_cancel="onCancel" @on_new_grade="newGrade"></grade-form>
    <el-row>
      <el-col :span="24">
        <el-button v-if="is_editing" @click="newGrade">{{$t('common.new-grade')}}</el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { createGrade } from '../../api/grades';
import gradeForm from './components/form';
export default {
  name: 'Add',
  data() {
    return {
      grade: {
        id: 0,
        name: '',
      },
      is_editing: false,
    };
  },
  components: {
    'grade-form': gradeForm,
  },
  methods: {
    onSubmit() {
      createGrade(this.grade).then(data => {
        this.grade.id = data[0].id;
        this.is_editing = true;
        this.$message('Success!');
        // this.$router.push({ path: '/grades/list' });
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
      this.newGrade();
      this.$router.back();
    },
    newGrade() {
      this.is_editing = false;
      this.grade = {
        id: 0,
        name: '',
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

