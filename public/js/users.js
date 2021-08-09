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
Livewire.on("triggerCreate", function () {
  console.log("OK");
  $("#createChatGroupModal").modal("show");
});
Livewire.on("dataFetched", function (chat) {
  console.log(chat);
  $("#editChatGroupModal").modal("show");
  $(".select2").select2();
});
window.addEventListener("group-saved", function (event) {
  $("#createChatGroupModal").modal("hide");
  alert("Chat Group ".concat(event.detail.title, " was ").concat(event.detail.action, "!"));
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
/******/ })()
;