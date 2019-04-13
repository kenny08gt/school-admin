/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/views/layout/Layout';

const gradesRouter = {
  path: '/grades',
  component: Layout,
  redirect: 'noredirect',
  name: 'Grades',
  meta: {
    title: 'Grades',
    icon: 'documentation',
  },
  children: [
    {
      path: 'add',
      component: () => import('@/views/grades/Add'),
      name: 'AddGrade',
      meta: { title: 'Add Grade', noCache: true },
    },
    {
      path: 'list',
      component: () => import('@/views/grades/List'),
      name: 'listGrades',
      meta: { title: 'List Grades', noCache: true },
    },
  ],
};

export default gradesRouter;
