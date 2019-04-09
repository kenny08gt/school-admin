/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/views/layout/Layout';
import addLayout from '@/views/courses/Add';
import listLayout from '@/views/courses/List';

const coursesRouter = {
  path: '/courses',
  component: Layout,
  redirect: 'noredirect',
  name: 'Courses',
  meta: {
    title: 'Courses',
    icon: 'documentation',
  },
  children: [
    {
      path: 'add',
      component: () => addLayout,
      name: 'AddCourse',
      meta: { title: 'Add Course', noCache: true },
    },
    {
      path: 'list',
      component: () => listLayout,
      name: 'listCourses',
      meta: { title: 'List Courses', noCache: true },
    },
    // {
    //   path: 'line',
    //   component: () => import('@/views/charts/Line'),
    //   name: 'LineChart',
    //   meta: { title: 'lineChart', noCache: true },
    // },
    // {
    //   path: 'mixchart',
    //   component: () => import('@/views/charts/MixChart'),
    //   name: 'MixChart',
    //   meta: { title: 'mixChart', noCache: true },
    // },
  ],
};

export default coursesRouter;
