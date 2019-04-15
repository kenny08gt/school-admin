import { createProfessor } from '../api/professors';

export default class Professor {
  constructor(gradeRaw) {
    this.update(gradeRaw);
  }

  update(professorRaw) {
    this.id = professorRaw.id;
    this.name = professorRaw.name;
    this.role = professorRaw.role;
    this.created_at = professorRaw.created_at;
    this.email = professorRaw.email;
    this.password = professorRaw.password;
    this.courses = professorRaw.courses;
  }

  save() {
    createProfessor(this).then((data) => {
      this.update(data[0]);
    }).catch((error) => {
      console.log('error', error);
    });
  }
}

new Professor({
  id: 0,
  name: '',
  email: '',
  password: '',
  role: 'professor',
  courses: [],
});

