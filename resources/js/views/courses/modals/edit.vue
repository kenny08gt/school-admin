<template>
  <el-dialog :title="$t('edit-course-modal.title')" :visible.sync="dialogFormVisible">
    <course-form :course="course" :grades="grades" @on_submit="onSubmit" @on_cancel="onCancel"></course-form>
  </el-dialog>
</template>

<script>
import { createCourse } from '../../../api/courses';
import courseForm from '../components/form';
import Course from '../../../objects/course';
export default {
  name: 'edit-course-modal',
  data() {
    return {
      dialogFormVisible: false,
      is_editing: false,
      course: {
        id: 0,
        name: '',
        grade_id: '',
        description: '',
      },
      course_clone: null,
      prev_name: '',
      prev_grade_id: '',
      prev_description: '',
    };
  },
  components: {
    'course-form': courseForm,
  },
  props: {
    grades: null,
  },
  methods: {
    show(course) {
      this.course = course;
      this.course_clone = new Course(JSON.parse(JSON.stringify(this.course)));
      this.dialogFormVisible = true;
    },
    hide() {
      this.dialogFormVisible = false;
    },
    onSubmit() {
      createCourse(this.course).then(data => {
        this.course.update(data[0]);
        this.is_editing = false;
        this.$message('Success!');
        this.hide();
      }).catch((error) => {
        console.log('error', error);
        this.$message({
          message: 'cancel!',
          type: 'warning',
        });
      });
    },
    onCancel() {
      this.course.update(this.course_clone);
      this.hide();
    },
  },
};
</script>

<style scoped>

</style>
