/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/views/layout/Layout';

const studentsRouter = {
  path: '/students',
  component: Layout,
  redirect: 'noredirect',
  name: 'students',
  meta: {
    title: 'students',
    icon: 'documentation',
  },
  children: [
    {
      path: 'add',
      component: () => import('@/views/students/Add'),
      name: 'AddStudent',
      meta: { title: 'Add Student', noCache: true },
    },
    {
      path: 'list',
      component: () => import('@/views/students/List'),
      name: 'listStudents',
      meta: { title: 'List Students', noCache: true },
    },
  ],
};

export default studentsRouter;
