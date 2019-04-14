import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/professors',
    method: 'post',
    params: query,
  });
}

export function createProfessor(query) {
  return request({
    url: '/professors/add',
    method: 'post',
    params: query,
  });
}

export function deleteProfessor(query) {
  return request({
    url: '/professors',
    method: 'delete',
    params: query,
  });
}
