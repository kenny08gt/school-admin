<template>
  <div class="app-container">
    <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column align="left" label="Name">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column align="left" label="Email">
        <template slot-scope="scope">
          <span>{{ scope.row.email }}</span>
        </template>
      </el-table-column>
      <el-table-column align="left" label="Created at">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Action">
        <template slot-scope="scope">
          <el-row>
            <el-button type="primary" icon="el-icon-edit" circle @click="editProfessor(scope.row)"></el-button>
            <el-button type="danger" icon="el-icon-delete" circle @click="deleteProfessorRequest(scope.row)"></el-button>
          </el-row>
        </template>
      </el-table-column>
    </el-table>
    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
    <edit-professor-modal ref="editProfessorModal"></edit-professor-modal>
  </div>
</template>

<script>
import { fetchList, deleteProfessor } from '@/api/professors';
import Pagination from '@core/components/Pagination';
import Professor from '@/objects/professor';
import editProfessorModal from './modals/edit';
export default {
  name: 'gradesList',
  components: {
    Pagination,
    'edit-professor-modal': editProfessorModal,
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
        this.list = response.items.map(function(item, index) {
          return new Professor(item);
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
    editProfessor(professor) {
      this.$refs.editProfessorModal.show(professor);
    },
    deleteProfessorRequest(professor) {
      this.$confirm('This will permanently delete this. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        deleteProfessor(professor).then((data) => {
          const index = this.list.indexOf(professor);
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

