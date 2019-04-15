import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/students',
    method: 'post',
    params: query,
  });
}

export function createStudent(query) {
  return request({
    url: '/students/add',
    method: 'post',
    params: query,
  });
}

export function deleteStudent(query) {
  return request({
    url: '/students',
    method: 'delete',
    params: query,
  });
}
