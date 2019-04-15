/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/views/layout/Layout';

const scoreRouter = {
  path: '/scores',
  component: Layout,
  redirect: 'noredirect',
  name: 'scores',
  meta: {
    title: 'scores',
    icon: 'peoples',
  },
  children: [
    {
      path: 'add',
      component: () => import('@/views/scores/grade'),
      name: 'grade',
      meta: { title: 'Per Grade', noCache: true },
    },
  ],
};

export default scoreRouter;
