<template>
  <el-dialog :title="$t('edit-student-modal.title')" :visible.sync="dialogFormVisible">
    <student-form ref="studentFormRef" :grades="grades" :student="student" :is_editing="true"
                  @on_submit="onSubmit" @on_cancel="onCancel"></student-form>
  </el-dialog>
</template>

<script>
import { createStudent } from '../../../api/students';
import studentForm from '../components/student-form';
import Student from '../../../objects/student';
export default {
  name: 'edit-student-modal',
  data() {
    return {
      dialogFormVisible: false,
      is_editing: false,
      student: {
        id: 0,
        name: '',
        grade: null,
        grade_id: null,
      },
      student_clone: null,
    };
  },
  props: {
    grades: null,
  },
  components: {
    'student-form': studentForm,
  },
  methods: {
    show(student) {
      this.student = student;
      this.student_clone = new Student(JSON.parse(JSON.stringify(this.student)));
      this.dialogFormVisible = true;
      // this.$refs.studentFormRef.showing();
    },
    hide() {
      this.dialogFormVisible = false;
    },
    onSubmit() {
      createStudent(this.student).then(data => {
        this.student.update(data[0]);
        this.is_editing = false;
        this.$message('Success!');
        this.hide();
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
      this.student.update(this.student_clone);
      this.hide();
    },
  },
};
</script>

<style scoped>

</style>
