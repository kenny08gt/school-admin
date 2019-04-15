<template>
  <el-form ref="form" :model="professor" label-width="120px">
    <el-form-item :label="$t('common.name')"  :rules="[
      { required: true, message: 'Please input a name', trigger: 'blur' }]">
      <el-input v-model="professor.name"/>
    </el-form-item>
    <el-form-item :label="$t('common.email')" :rules="[
      { required: true, message: 'Please input email address', trigger: 'blur' },
      { type: 'email', message: 'Please input correct email address', trigger: ['blur', 'change'] }]">
      <el-input type="email" v-model="professor.email"/>
    </el-form-item>
    <el-form-item v-if="!is_editing" :label="$t('common.password')" :rules="[
      { required: true, message: 'Please input a password', trigger: 'blur' },
      { type: 'password', message: 'Please input a valid password', trigger: ['blur', 'change'] }]">
      <el-input type="password" v-model="professor.password"/>
    </el-form-item>
    <el-form-item :label="$t('common.course')">
      <el-select v-model="selected_courses" placeholder="please select the courses" :multiple="true">
        <el-option v-for="(course) in courses" :key="course.id" :value="course.id" :label="course.name"/>
      </el-select>
    </el-form-item>
    <el-form-item :label="$t('common.role')" :rules="[
      { required: true}]">
      <el-input v-model="professor.role" :disabled="true"/>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" @click="onSubmit">
        <template v-if="is_editing">
          {{$t('common.save-changes')}}
        </template>
        <template v-else>
          {{$t('common.create')}}
        </template>
      </el-button>
      <el-button @click="onCancel">
        <template v-if="is_editing">
          {{$t('common.back')}}
        </template>
        <template v-else>
          {{$t('common.cancel')}}
        </template>
      </el-button>
    </el-form-item>
  </el-form>
</template>

<script>
export default {
  name: 'professor-form',
  props: {
    professor: null,
    is_editing: null,
    courses: null,
  },
  data() {
    return {
      selected_courses: null,
    };
  },
  created() {
    this.selected_courses = this.professor.courses.map(function(item) {
      return item.id;
    });
  },
  methods: {
    onSubmit() {
      this.professor.courses = this.selected_courses;
      this.$emit('on_submit');
    },
    onCancel() {
      this.$emit('on_cancel');
    },
    newProfessor() {
      this.$emit('on_newprofessor');
    },
  },
};
</script>

<style scoped>

</style>
