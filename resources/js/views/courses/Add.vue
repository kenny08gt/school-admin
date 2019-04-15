<template>
  <div class="app-container">
    <course-form :course="course" :grades="gradesList" @on_submit="onSubmit" @on_cancel="onCancel"></course-form>
    <el-row>
      <el-col :span="24">
        <el-button v-if="is_editing" @click="newCourse">{{$t('common.new-course')}}</el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { createCourse } from '@/api/courses';
import { fetchList } from '@/api/grades';
import couseForm from './components/form';
import Grade from '../../objects/grade';

export default {
  name: 'Add',
  data() {
    return {
      gradesList: null,
      course: null,
      is_editing: false,
    };
  },
  components: {
    'course-form': couseForm,
  },
  created() {
    this.getGradeList();
    this.newCourse();
  },
  methods: {
    onSubmit() {
      createCourse(this.course).then(data => {
        console.log('data', data);
        this.course.id = data[0].id;
        this.is_editing = true;
        this.$message(this.$t('common.success'));
        // this.$router.push({ path: '/courses/list' });
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
      this.newCourse();
      this.$router.back();
    },
    newCourse() {
      this.is_editing = false;
      this.course = {
        id: 0,
        name: '',
        grades: [],
        description: '',
      };
    },
    getGradeList() {
      fetchList().then(response => {
        this.gradesList = response.items.map(function(item, index) {
          return new Grade(item);
        });
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

