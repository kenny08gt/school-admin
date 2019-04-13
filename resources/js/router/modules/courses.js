/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/views/layout/Layout';

const coursesRouter = {
  path: '/courses',
  component: Layout,
  redirect: 'noredirect',
  name: 'courses',
  meta: {
    title: 'courses',
    icon: 'documentation',
  },
  children: [
    {
      path: 'add',
      component: () => import('@/views/courses/Add'),
      name: 'AddCourse',
      meta: { title: 'Add Course', noCache: true },
    },
    {
      path: 'list',
      component: () => import('@/views/courses/List'),
      name: 'listCourses',
      meta: { title: 'List Courses', noCache: true },
    },
  ],
};

export default coursesRouter;
