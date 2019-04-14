<template>
  <div class="app-container">
    <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column align="left" :label="$t('common.name')">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column align="left" :label="$t('common.created-at')">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at | moment("LL") }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" :label="$t('common.actions')">
        <template slot-scope="scope">
          <el-row>
            <el-button type="primary" icon="el-icon-edit" circle @click="editGrade(scope.row)"></el-button>
            <el-button type="danger" icon="el-icon-delete" circle @click="deleteGradeRequest(scope.row)"></el-button>
          </el-row>
        </template>
      </el-table-column>
    </el-table>
    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
    <edit-grade-modal ref="editGradeModal"></edit-grade-modal>
  </div>
</template>

<script>
import { fetchList, deleteGrade } from '@/api/grades';
import Pagination from '@core/components/Pagination'; // Secondary package based on el-pagination
import editModal from './modals/edit';
import Grade from '@/objects/grade';

export default {
  name: 'gradesList',
  components: {
    Pagination,
    'edit-grade-modal': editModal,
  },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger',
      };
      return statusMap[status];
    },
  },
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
      },
    };
  },
  created() {
    this.getList();
  },
  methods: {
    getList() {
      this.listLoading = true;
      fetchList(this.listQuery).then(response => {
        this.list = response.items.map((item, index) => {
          return new Grade(item);
        });
        this.total = response.total;
        this.listLoading = false;
      }).catch((error) => {
        console.log('error', error);
      });
    },
    handleSizeChange(val) {
      this.listQuery.limit = val;
      this.getList();
    },
    handleCurrentChange(val) {
      this.listQuery.page = val;
      this.getList();
    },
    editGrade(grade) {
      this.$refs.editGradeModal.show(grade);
    },
    deleteGradeRequest(grade) {
      console.log('grade ', grade);
      this.$confirm(this.$t('common.delete-message'), 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        deleteGrade(grade).then((data) => {
          const index = this.list.indexOf(grade);
          this.list.splice(index, 1);
          this.$message({
            type: 'success',
            message: 'Delete completed',
          });
        }).catch((error) => {
          console.log('error', error);
          this.$message({
            type: 'info',
            message: 'Something went wrong',
          });
        });
      });
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

