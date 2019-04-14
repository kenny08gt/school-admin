<template>
  <el-dialog :title="$t('edit-grade-modal.title')" :visible.sync="dialogFormVisible">
    <el-form ref="form" :model="grade" label-width="120px">
      <el-form-item :label="$t('common.name')">
        <el-input v-model="grade.name"/>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">{{$t('common.save-changes')}}</el-button>
        <el-button @click="onCancel">{{$t('common.cancel')}}</el-button>
      </el-form-item>
    </el-form>
    <!--<span slot="footer" class="dialog-footer">-->
    <!--<el-button @click="dialogFormVisible = false">Cancel</el-button>-->
    <!--<el-button type="primary" @click="dialogFormVisible = false">Confirm</el-button>-->
  <!--</span>-->
  </el-dialog>
</template>

<script>
import { createGrade } from '../../../api/grades';
export default {
  name: 'edit-grade-modal',
  data() {
    return {
      dialogFormVisible: false,
      is_editing: false,
      previous_name: '',
      grade: {
        id: 0,
        name: '',
      },
    };
  },
  methods: {
    show(grade) {
      this.grade = grade;
      this.previous_name = grade.name;
      this.dialogFormVisible = true;
    },
    hide() {
      this.dialogFormVisible = false;
    },
    onSubmit() {
      createGrade(this.grade).then(data => {
        this.grade.update(data[0]);
        this.is_editing = false;
        this.$message('Success!');
        this.hide();
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
      this.grade.name = this.previous_name;
      this.hide();
    },
  },
};
</script>

<style scoped>

</style>
