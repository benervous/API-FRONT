var id = null;

async function getPosts(){
  let res = await fetch('/api/posts');
  let posts = await res.json();
 document.querySelector('.post-list').innerHTML = '';

  posts.forEach((post) => {
    document.querySelector('.post-list').innerHTML += `
    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">${post.title}</h5>
        <p class="card-text">${post.body}</p>
        <a href="#" class="card-link">Поподробнее</a>
        <a href="#" class="card-link" onclick="removePost(${post.Id})">Удалить</a>
        <a href="#" class="card-link" onclick="selectPost('${post.Id}','${post.title}', '${post.body}' )">Редактировать</a>
      </div>
    </div>
    `
  })
}
 async function addPost(){
  const title = document.getElementById('title').value,
   body = document.getElementById('body').value;

   let formData = new FormData();
 formData.append('title', title);
  formData.append('body', body);
    const res = await fetch('/api/posts', {
      method:'POST',
       body: formData
  });
  const data = await res.json();
  if(data.status === true){
    await getPosts();
  }
  }

async function removePost(id){
  const res = await fetch (`/api/posts/${id}`, {
    method: "DELETE"
  });
  const data = await res.json();
  if(data.status === true){
    await getPosts();
  }
}
function selectPost(id, title, body){
  id = id;
  document.getElementById('title-edit').value = title;
  document.getElementById('body-edit').value = body;
  document.getElementById('editing-element').value = id;

}
async function updatePost(){
const title = document.getElementById('title-edit').value,
body = document.getElementById('body-edit').value;
id =  document.getElementById('editing-element').value;

const data = {
  title: title,
  body: body
};

const res = await fetch(`/api/posts/${id}`, {
  method: "PATCH",
  body: JSON.stringify(data)
});
let resData= res.json();

if(resData.status === true){
  await getPosts();
}
location.reload();
}


getPosts();
