<template>
  <el-dialog :title="$t('edit-professor-modal.title')" :visible.sync="dialogFormVisible">
    <professor-form :courses="courses" :professor="professor" :is_editing="true" @on_submit="onSubmit" @on_cancel="onCancel"></professor-form>
  </el-dialog>
</template>

<script>
import { createProfessor } from '../../../api/professors';
import professorFrom from '../components/professor-form';
import Professor from '../../../objects/professor';
export default {
  name: 'edit-professor-modal',
  data() {
    return {
      dialogFormVisible: false,
      is_editing: false,
      professor: {
        id: 0,
        name: '',
        email: '',
        password: '',
        role: 'professor',
      },
      professor_clone: null,
    };
  },
  props: {
    courses: null,
  },
  components: {
    'professor-form': professorFrom,
  },
  methods: {
    show(professor) {
      this.professor = professor;
      this.professor_clone = new Professor(JSON.parse(JSON.stringify(this.professor)));
      this.dialogFormVisible = true;
    },
    hide() {
      this.dialogFormVisible = false;
    },
    onSubmit() {
      createProfessor(this.professor).then(data => {
        this.professor.update(data[0]);
        this.is_editing = false;
        this.$message('Success!');
        this.hide();
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
      this.professor.update(this.professor_clone);
      this.hide();
    },
  },
};
</script>

<style scoped>

</style>
