<template>
  <el-dialog :title="$t('edit-course-modal.title')" :visible.sync="dialogFormVisible">
    <course-form :course="course" :grades="grades" @on_submit="onSubmit" @on_cancel="onCancel"></course-form>
  </el-dialog>
</template>

<script>
import { createCourse } from '../../../api/courses';
import courseForm from '../components/form';
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
      this.prev_name = course.name;
      this.prev_grade_id = course.grade_id;
      this.prev_description = course.description;
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
      this.course.name = this.prev_name;
      this.course.grade_id = this.prev_grade_id;
      this.course.description = this.prev_description;
      this.hide();
    },
  },
};
</script>

<style scoped>

</style>
