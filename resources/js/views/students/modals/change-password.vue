<template>
  <el-dialog :title="$t('change-password-modal.title')" :visible.sync="dialogFormVisible">
    <el-form ref="form" :model="professor" label-width="120px">
      <el-form-item :label="$t('common.password')" :rules="[
      { required: true, message: 'Please input a password', trigger: 'blur' },
      { type: 'password', message: 'Please input a valid password', trigger: ['blur', 'change'] }]">
        <el-input ref="passwordInput" :type="password_field_type" v-model="professor.password"/>
        <el-button class="show-password" type="info" circle icon="el-icon-view" @click="showPassword"></el-button>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">
          {{$t('common.save-changes')}}
        </el-button>
        <el-button @click="onCancel">
          {{$t('common.cancel')}}
        </el-button>
      </el-form-item>
    </el-form>
  </el-dialog>
</template>

<script>
import { createProfessor } from '../../../api/professors';
export default {
  name: 'change-password-modal',
  data() {
    return {
      dialogFormVisible: false,
      password: '',
      confirm_password: '',
      password_field_type: 'password',
      professor: {
        id: 0,
        name: '',
        email: '',
        password: '',
        role: 'professor',
      },
    };
  },
  props: {
  },
  components: {
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
      createProfessor({ id: this.professor.id, password: this.professor.password }).then(data => {
        this.professor.update(data[0]);
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
      this.hide();
    },
    showPassword() {
      if (this.password_field_type === 'password') {
        this.password_field_type = 'text';
      } else {
        this.password_field_type = 'password';
      }
    },
  },
};
</script>

<style scoped>
  .show-password {
    position: absolute;
    top: 50%;
    right: 5px;
    padding: 5px;
    transform: translateY(-50%);
  }
</style>
