<template>
  <div class="app-container">
    <el-form ref="form" :model="course" label-width="120px">
      <el-form-item :label="$t('common.name')">
        <el-input v-model="course.name"/>
      </el-form-item>
      <el-form-item :label="$t('common.grade')">
        <el-select v-model="course.grade_id" placeholder="please select the grades" :multiple="false">
          <el-option v-for="(grade) in grades" :key="grade.key" :value="grade.key" :label="grade.name"/>
        </el-select>
      </el-form-item>
      <el-form-item :label="$t('common.description')">
        <el-input v-model="course.description" type="textarea"/>
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
        <el-button v-if="is_editing" @click="newCourse">{{$t('common.new-course')}}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { createCourse } from '@/api/courses';
export default {
  name: 'Add',
  data() {
    return {
      course: {
        id: 0,
        name: '',
        grade_id: '',
        description: '',
      },
      grades: [
        {
          'key': '1',
          'name': 'primero' },
        {
          'key': '2',
          'name': 'segundo' },
      ],
      is_editing: false,
    };
  },
  components: {
  },
  methods: {
    onSubmit() {
      createCourse(this.course).then(data => {
        console.log('data', data);
        this.course.id = data[0].id;
        this.is_editing = true;
        this.$message(this.$t('common.success'));
        // this.$router.push({ path: '/courses/list' });
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
      this.newCourse();
      this.$router.back();
    },
    newCourse() {
      this.is_editing = false;
      this.course = {
        id: 0,
        name: '',
        grade_id: '',
        description: '',
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

