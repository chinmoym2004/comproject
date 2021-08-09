/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/users.js ***!
  \*******************************/
Livewire.on("deleteTriggered", function (id, name) {
  var proceed = confirm("Are you sure you want to delete ".concat(name));

  if (proceed) {
    Livewire.emit("destroy", id);
  }
});
window.addEventListener("chat-grpup-deleted", function (event) {
  alert("".concat(event.detail.title, " was deleted!"));
});
window.addEventListener("forum-deleted", function (event) {
  alert("".concat(event.detail.title, " was deleted!"));
});
Livewire.on("triggerCreate", function () {
  console.log("OK");
  $("#createChatGroupModal").modal("show");
});
Livewire.on("dataFetched", function (chat) {
  console.log(chat);
  $("#editChatGroupModal").modal("show");
  $(".select2").select2();
});
Livewire.on("forumCreate", function () {
  console.log("OK");
  $("#createForumModal").modal("show");
});
window.addEventListener("group-saved", function (event) {
  $("#createChatGroupModal").modal("hide");
  alert("Chat Group ".concat(event.detail.title, " was ").concat(event.detail.action, "!"));
});
window.addEventListener("forum-saved", function (event) {
  $("#createForumModal").modal("hide");
  alert("Forum ".concat(event.detail.title, " was ").concat(event.detail.action, "!"));
});
window.addEventListener("forum-updated", function (event) {
  $("#editForumModal").modal("hide");
  alert("Forum ".concat(event.detail.title, " was ").concat(event.detail.action, "!"));
});
window.addEventListener("chatSaved", function (event) {});
$(document).on("click", "#selectallmember", function (event) {
  event.preventDefault();
  $("#editChatGroupModal .select2 > option").prop("selected", "selected").trigger("change");
  $("#chatMembers").trigger("change");
  Livewire.emit('chatMembersSelected', $('#chatMembers').select2('val'));
});
$('#chatMembers').on('select2:close', function (e) {
  $("#chatMembers").trigger("change");
  Livewire.emit('chatMembersSelected', $('#chatMembers').select2('val'));
});
window.livewire.on("deleteForumTriggered", function (id, name) {
  var proceed = confirm("Are you sure you want to delete Forum ".concat(name));

  if (proceed) {
    Livewire.emit("destroyForum", id);
    console.log("Ok..emit");
  }
});
Livewire.on("forumDataFetched", function (forum) {
  $("#editForumModal").modal("show");
});
/******/ })()
;