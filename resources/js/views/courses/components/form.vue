<template>
  <el-form ref="form" :model="course" label-width="120px">
    <el-form-item :label="$t('common.name')">
      <el-input v-model="course.name"/>
    </el-form-item>
    <el-form-item label="Grade ">
      <el-select v-model="course.grades" placeholder="please select the grades" :multiple="true">
        <el-option v-for="(grade) in grades" :key="grade.id" :value="grade.id" :label="grade.name"/>
      </el-select>
    </el-form-item>
    <el-form-item :label="$t('common.description')">
      <el-input v-model="course.description" type="textarea"/>
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
</template>

<script>
export default {
  name: 'course-form',
  props: {
    course: null,
    grades: null,
  },
  methods: {
    onSubmit() {
      this.$emit('on_submit');
    },
    onCancel() {
      this.$emit('on_cancel');
    },
  },
};
</script>

<style scoped>

</style>
