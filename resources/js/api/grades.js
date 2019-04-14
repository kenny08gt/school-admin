import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/grades',
    method: 'post',
    params: query,
  });
}

export function createGrade(query) {
  return request({
    url: '/grades/add',
    method: 'post',
    params: query,
  });
}

export function deleteGrade(query) {
  return request({
    url: '/grades',
    method: 'delete',
    params: query,
  });
}
