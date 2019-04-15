import { createGrade } from '../api/grades';

export default class Grade {
  constructor(gradeRaw) {
    this.update(gradeRaw);
  }

  update(gradeRaw) {
    this.id = gradeRaw.id;
    this.name = gradeRaw.name;
    this.created_at = gradeRaw.created_at;
  }

  save() {
    createGrade(this).then((data) => {
      console.log('success', data);
    }).catch((error) => {
      console.log('error', error);
    });
  }
}

new Grade({
  id: 0,
  name: '',
  created_at: '',
});

