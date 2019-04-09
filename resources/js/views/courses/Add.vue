<template>
  <div class="app-container">
    <el-form ref="form" :model="course" label-width="120px">
      <el-form-item label="Course name">
        <el-input v-model="course.name"/>
      </el-form-item>
      <el-form-item label="Grade ">
        <el-select v-model="course.grade_id" placeholder="please select the grades" :multiple="true">
          <el-option v-for="(grade) in grades" :key="grade.key" :value="grade.key" :label="grade.name"/>
        </el-select>
      </el-form-item>
      <el-form-item label="Description">
        <el-input v-model="course.description" type="textarea"/>
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
        <el-button @click="onCancel">Cancel</el-button>
        <el-button v-if="is_editing" @click="newCourse">New Task</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
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
      is_editing: this.course.id > 0,
    };
  },
  components: {
  },
  methods: {
    onSubmit() {
      window.axios.post('/courses/add', this.course
      ).then((data) => {
        console.log('then', data);
        this.course.id = data.id;
        this.$message('submit!');
      }).catch((error) => {
        console.log('error', error);
        this.$message({
          message: 'cancel!',
          type: 'warning',
        });
      });
    },
    onCancel() {
      this.$message({
        message: 'cancel!',
        type: 'warning',
      });
    },
    newCourse() {
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

