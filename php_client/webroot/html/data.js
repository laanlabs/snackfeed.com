dojo.require("dojo.event.*");
dojo.require("dojo.io.*");
dojo.require("dojo.date.*");
dojo.require("dojo.lfx.*");
 
function getArticle(id) {
var idStr = "{\"id\":" + id + "}";
request = {'action' : 'getArticle', 'data' : idStr};
dojo.io.bind({
url: "http://v1.smoothtube.com/shows/get_show_list?json=1",
handler: showArticle,
mimetype: "text/json",
content: request
});
}
 
function showArticle(type, data, evt) {
dojo.dom.removeChildren(dojo.byId('article'));
appendArticlePart('title', data.title);
var date = dojo.date.fromSql(data.time);
appendArticlePart('time', dojo.date.toRelativeString(date));
appendArticlePart('content', data.content);
dojo.lfx.highlight(dojo.byId('article'), dojo.lfx.Color);
}
 
function appendArticlePart(id, value) {
var element = document.createElement("div");
element.id=id;
element.innerHTML=value;
dojo.byId('article').appendChild(element);
}