<template>
  <el-form ref="form" :model="grade" label-width="120px">
    <el-form-item :label="$t('common.name')">
      <el-input v-model="grade.name"/>
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
  name: 'form',
  data() {
    return {
    };
  },
  props: {
    grade: null,
    is_editing: null,
  },
  methods: {
    onSubmit() {
      this.$emit('on_submit');
    },
    onCancel() {
      this.$emit('on_cancel');
    },
    newGrade() {
      this.$emit('on_new_grade');
    },
  },
};
</script>

<style scoped>

</style>
