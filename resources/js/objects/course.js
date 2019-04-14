import { createCourse } from '../api/courses';

export default class Course {
  constructor(courseRaw) {
    this.update(courseRaw);
  }

  update(courseRaw) {
    this.id = courseRaw.id;
    this.name = courseRaw.name;
    this.created_at = courseRaw.created_at;
    this.grade_id = courseRaw.grade_id;
    this.description = courseRaw.description;
  }

  save() {
    createCourse(this).then((data) => {
      console.log('success', data);
    }).catch((error) => {
      console.log('error', error);
    });
  }
}

new Course({
  id: 0,
  name: '',
  description: '',
  grape_id: 0,
  created_at: '',
});

