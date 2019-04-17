/* eslint-disable new-cap */
<template>
  <div class="app-container" v-loading.fullscreen.lock="loading">
    <label>Select a grade</label>
    <el-select v-model="grade.id" placeholder="Select" style="margin-bottom: 5px;" @change="generateGradeReport">
      <el-option
        v-for="grade in grades"
        :key="grade.id"
        :label="grade.name"
        :value="grade.id">
      </el-option>
    </el-select>
    <el-row v-if="grade.id" style="margin-top: 10px;">
      <el-col :span="24">
        <!--<el-button type="success" @click="generateGradeReport">-->
          <!--{{$t('common.generate')}}-->
        <!--</el-button>-->
        <el-button type="warning" @click="generatePrint" v-if="students">
          {{$t('common.print')}}
        </el-button>
        <el-button @click="$router.back()">
          {{$t('common.back')}}
        </el-button>
      </el-col>
    </el-row>
    <el-row :gutter="12" id="scoresReport" ref="scoresReport">
        <el-card id="scoreReport" class="box-card score-report" v-for="student in students" :key="'student.' + student.id" shadow="always" style="margin: 15px 0;">
          <div class="info">
            <div class="header">
              <div class="left">
                <img src="/static/logo1.jpg" alt="Logo">
              </div>
              <div class="right">
                <p>Lorem ipsum dolor sit amet.</p>
                <p>Lorem ipsum dolor.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
              </div>
              <h1>Score Report</h1>
            </div>
            <table>
              <tbody>
              <tr>
                <td><strong>Name:</strong></td>
                <td>{{student.name}}</td>
              </tr>
              <tr>
                <td><strong>Grade:</strong></td>
                <td>{{student.grade.name}}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="scores">
            <table>
              <thead>
                <tr>
                  <th>Course</th>
                  <th>Score</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="course in student.courses">
                  <td>{{course.name}}</td>
                  <td>{{course.pivot.score}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="footer">
            <small>Created with http://schoolkit.alanhurtarte.com</small>
          </div>
        </el-card>
    </el-row>
  </div>
</template>
<script>
import { fetchList as fetchGradesList } from '@/api/grades';
import { fetch } from '../../api/students';
import Grade from '../../objects/grade';
import Student from '../../objects/student';
// import * as JsPDF from 'jspdf';
import html2pdf from 'html2pdf.js';

export default {
  name: 'gradesList',
  components: {
  },
  data() {
    return {
      grades: [],
      grade: {
        courses: [],
      },
      students: [],
      loading: false,
    };
  },
  mounted() {
  },
  created() {
    this.getGradesList();
  },
  methods: {
    getGradesList() {
      this.loading = true;
      fetchGradesList().then(response => {
        this.grades = response.items.map(function(item, index) {
          return new Grade(item);
        });
        this.loading = false;
      }).catch((error) => {
        console.log('error', error);
      });
    },
    generateGradeReport() {
      this.loading = true;
      fetch({ grade_id: this.grade.id }).then(response => {
        this.students = response[0].map(function(student) {
          return new Student(student);
        });
        this.loading = false;
      }).catch((error) => {
        console.log('error', error);
      });
      console.log('generate pdf');
    },
    generatePrint() {
      const element = document.getElementById('scoresReport');
      // html2pdf(document.getElementById('scoresReport'));
      html2pdf().from(element).set({
        pagebreak: { mode: 'avoid-all', before: '#scoreReport' },
      }).save('scores_report_' + this.grade.id);
    },
  },
};
</script>

<style scoped lang="scss">
  input {
    padding: 5px;
  }

  @page {
    margin: 0 auto;
    size: auto;
  }

  /*body { margin: 1.6cm; }*/
  header, footer {
    display: none;
  }

  .score-report {
    font-family: Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB, Microsoft YaHei, Arial, sans-serif;
    position: relative;

    .header {
      display: block;
      text-align: center;
      margin-bottom: 50px;

      .left {
        margin-right: 5px;

        img {
          height: 150px;
        }
      }

      .right {
        p {
          margin: 5px;
        }
      }
    }

    .scores {
      margin-top: 50px;

      table {
        margin-top: 50px;
        border-collapse: collapse;

        th, td {
          padding: 15px;
          text-align: left;
        }
      }

      table, th, td {
        border: 1px solid #adadad;
      }
    }

    .footer {
      position: absolute;
      bottom:  5px;
      right: 5px;
    }
  }
</style>

