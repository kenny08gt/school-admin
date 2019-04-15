<template>
  <el-form ref="form" :model="student" label-width="120px">
    <el-form-item :label="$t('common.name')"  :rules="[
      { required: true, message: 'Please input a name', trigger: 'blur' }]">
      <el-input v-model="student.name"/>
    </el-form-item>
    <el-form-item :label="$t('common.course')">
      <el-select v-model="student.grade_id" placeholder="please select the grade" :multiple="false">
        <el-option v-for="(grade) in grades" :key="grade.id" :value="grade.id" :label="grade.name"/>
      </el-select>
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
  name: 'student-form',
  props: {
    student: null,
    is_editing: null,
    grades: null,
  },
  data() {
    return {
      selected_grade: null,
    };
  },
  created() {
  },
  methods: {
    onSubmit() {
      this.$emit('on_submit');
    },
    onCancel() {
      this.$emit('on_cancel');
    },
    newProfessor() {
      this.$emit('on_newstudent');
    },
  },
};
</script>

<style scoped>

</style>
