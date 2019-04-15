import { createStudent } from '../api/students';

export default class Student {
  constructor(studentRaw) {
    this.update(studentRaw);
  }

  update(studentRaw) {
    this.id = studentRaw.id;
    this.name = studentRaw.name;
    this.picture = studentRaw.picture;
    this.created_at = studentRaw.created_at;
    this.grade = studentRaw.grade;
    this.grade_id = studentRaw.grade_id;
  }

  save() {
    createStudent(this).then((data) => {
      this.update(data[0]);
    }).catch((error) => {
      console.log('error', error);
    });
  }
}

new Student({
  id: 0,
  name: '',
  picture: '',
  grade: null,
});

