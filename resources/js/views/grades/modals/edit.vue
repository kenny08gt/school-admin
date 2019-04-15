<template>
  <el-dialog :title="$t('edit-grade-modal.title')" :visible.sync="dialogFormVisible">
    <grade-form :grade="grade" :is_editing="true" @on_submit="onSubmit" @on_cancel="onCancel"></grade-form>
  </el-dialog>
</template>

<script>
import { createGrade } from '../../../api/grades';
import gradeForm from '../components/form';
import Grade from '../../../objects/grade';
export default {
  name: 'edit-grade-modal',
  data() {
    return {
      dialogFormVisible: false,
      is_editing: false,
      previous_name: '',
      grade: {
        id: 0,
        name: '',
      },
      grade_clone: null,
    };
  },
  methods: {
    show(grade) {
      this.grade = grade;
      this.grade_clone = new Grade(JSON.parse(JSON.stringify(this.grade)));
      this.dialogFormVisible = true;
    },
    hide() {
      this.dialogFormVisible = false;
    },
    onSubmit() {
      createGrade(this.grade).then(data => {
        this.grade.update(data[0]);
        this.is_editing = false;
        this.$message('Success!');
        this.hide();
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
      this.grade.update(this.grade_clone);
      this.hide();
    },
  },
  components: {
    'grade-form': gradeForm,
  },
};
</script>

<style scoped>

</style>
