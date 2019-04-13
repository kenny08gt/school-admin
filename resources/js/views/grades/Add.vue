<template>
  <div class="app-container">
    <el-form ref="form" :model="grade" label-width="120px">
      <el-form-item label="Grade name">
        <el-input v-model="grade.name"/>
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
        <el-button v-if="is_editing" @click="newGrade">New Grade</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { createGrade } from '../../api/grades';
export default {
  name: 'Add',
  data() {
    return {
      grade: {
        id: 0,
        name: '',
      },
      is_editing: false,
    };
  },
  components: {
  },
  methods: {
    onSubmit() {
      createGrade(this.grade).then(data => {
        this.grade.id = data[0].id;
        this.is_editing = true;
        this.$message('Success!');
        // this.$router.push({ path: '/grades/list' });
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
      this.newGrade();
      this.$router.back();
    },
    newGrade() {
      this.is_editing = false;
      this.grade = {
        id: 0,
        name: '',
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

