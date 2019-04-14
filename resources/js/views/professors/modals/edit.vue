<template>
  <el-dialog title="Edit Professor" :visible.sync="dialogFormVisible">
    <el-form ref="form" :model="professor" label-width="120px">
      <el-form-item label="Name"  :rules="[
      { required: true, message: 'Please input a name', trigger: 'blur' }]">
        <el-input v-model="professor.name"/>
      </el-form-item>
      <el-form-item label="Email" :rules="[
      { required: true, message: 'Please input email address', trigger: 'blur' },
      { type: 'email', message: 'Please input correct email address', trigger: ['blur', 'change'] }]">
        <el-input type="email" v-model="professor.email"/>
      </el-form-item>
      <!--<el-form-item v-if="!is_editing" label="Passoword" :rules="[-->
      <!--{ required: true, message: 'Please input a password', trigger: 'blur' },-->
      <!--{ type: 'password', message: 'Please input a valid password', trigger: ['blur', 'change'] }]">-->
        <!--<el-input type="password" v-model="professor.password"/>-->
      <!--</el-form-item>-->
      <!--<el-form-item label="Role" :rules="[-->
      <!--{ required: true}]">-->
        <!--<el-input v-model="professor.role" :disabled="true"/>-->
      <!--</el-form-item>-->
      <el-form-item>
        <el-button type="primary" @click="onSubmit">
          Save Changes
        </el-button>
        <el-button @click="onCancel">
          Cancel
        </el-button>
      </el-form-item>
    </el-form>
  </el-dialog>
</template>

<script>
import { createProfessor } from '../../../api/professors';
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
    };
  },
  methods: {
    show(professor) {
      this.professor = professor;
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
      this.professor.name = this.previous_name;
      this.hide();
    },
  },
};
</script>

<style scoped>

</style>
