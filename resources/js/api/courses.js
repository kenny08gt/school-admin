import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/courses',
    method: 'post',
    params: query,
  });
}

export function createCourse(query) {
  return request({
    url: '/courses/add',
    method: 'post',
    params: query,
  });
}

export function deleteCourse(query) {
  return request({
    url: '/courses',
    method: 'delete',
    params: query,
  });
}
