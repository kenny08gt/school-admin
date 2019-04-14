<template>
  <el-dialog :title="$t('edit-course-modal.title')" :visible.sync="dialogFormVisible">
    <el-form ref="form" :model="course" label-width="120px">
      <el-form-item :label="$t('common.name')">
        <el-input v-model="course.name"/>
      </el-form-item>
      <!--<el-form-item label="Grade ">-->
        <!--<el-select v-model="course.grade_id" placeholder="please select the grades" :multiple="false">-->
          <!--<el-option v-for="(grade) in grades" :key="grade.key" :value="grade.key" :label="grade.name"/>-->
        <!--</el-select>-->
      <!--</el-form-item>-->
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
  </el-dialog>
</template>

<script>
import { createCourse } from '../../../api/courses';

export default {
  name: 'edit-course-modal',
  data() {
    return {
      dialogFormVisible: false,
      is_editing: false,
      course: {
        id: 0,
        name: '',
        grade_id: '',
        description: '',
      },
      prev_name: '',
      prev_grade_id: '',
      prev_description: '',
    };
  },
  methods: {
    show(course) {
      this.course = course;
      this.prev_name = course.name;
      this.prev_grade_id = course.grade_id;
      this.prev_description = course.description;
      this.dialogFormVisible = true;
    },
    hide() {
      this.dialogFormVisible = false;
    },
    onSubmit() {
      createCourse(this.course).then(data => {
        this.course.update(data[0]);
        this.is_editing = false;
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
      this.course.name = this.prev_name;
      this.course.grade_id = this.prev_grade_id;
      this.course.description = this.prev_description;
      this.hide();
    },
  },
};
</script>

<style scoped>

</style>
