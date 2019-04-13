/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/views/layout/Layout';

const professorRouter = {
  path: '/professors',
  component: Layout,
  redirect: 'noredirect',
  name: 'professors',
  meta: {
    title: 'professors',
    icon: 'peoples',
  },
  children: [
    {
      path: 'add',
      component: () => import('@/views/professors/Add'),
      name: 'AddProfessor',
      meta: { title: 'Add Professor', noCache: true },
    },
    {
      path: 'list',
      component: () => import('@/views/professors/List'),
      name: 'listProfessors',
      meta: { title: 'List Professors', noCache: true },
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

export default professorRouter;
