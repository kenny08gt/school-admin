import request from '@/utils/request';

export function update(query) {
  return request({
    url: '/scores',
    method: 'post',
    params: query,
  });
}

export function fetch(query) {
  return request({
    url: '/scores/get',
    method: 'post',
    params: query,
  });
}
