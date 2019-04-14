<template>
  <div class="app-container">
    <h2>Add Professor</h2>
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
      <el-form-item v-if="!is_editing" label="Passoword" :rules="[
      { required: true, message: 'Please input a password', trigger: 'blur' },
      { type: 'password', message: 'Please input a valid password', trigger: ['blur', 'change'] }]">
        <el-input type="password" v-model="professor.password"/>
      </el-form-item>
      <el-form-item label="Role" :rules="[
      { required: true}]">
        <el-input v-model="professor.role" :disabled="true"/>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">
          <template v-if="is_editing">
            Save Changes
          </template>
          <template v-else>
            Create
          </template>
        </el-button>
        <el-button @click="onCancel">
          <template v-if="is_editing">
            Back
          </template>
          <template v-else>
            Cancel
          </template>
        </el-button>
        <el-button v-if="is_editing" @click="newProfessor">New Professor</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { createProfessor } from '../../api/professors';
export default {
  name: 'Add',
  data() {
    return {
      professor: {
        id: 0,
        name: '',
        email: '',
        password: '',
        role: 'professor',
      },
      is_editing: false,
    };
  },
  components: {
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

