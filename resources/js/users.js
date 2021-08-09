Livewire.on("deleteTriggered", (id, name) => {
    const proceed = confirm(`Are you sure you want to delete ${name}`);
    if (proceed) {
        Livewire.emit("destroy", id);
    }
});

window.addEventListener("chat-grpup-deleted", (event) => {
    alert(`${event.detail.title} was deleted!`);
});

window.addEventListener("forum-deleted", (event) => {
    alert(`${event.detail.title} was deleted!`);
});

Livewire.on("triggerCreate", () => {
    console.log("OK");
    $("#createChatGroupModal").modal("show");
});

Livewire.on("dataFetched", (chat) => {
    console.log(chat);
    $("#editChatGroupModal").modal("show");
    $(".select2").select2();
});

Livewire.on("forumCreate", () => {
    console.log("OK");
    $("#createForumModal").modal("show");
});

window.addEventListener("group-saved", (event) => {
    $("#createChatGroupModal").modal("hide");
    alert(`Chat Group ${event.detail.title} was ${event.detail.action}!`);
});

window.addEventListener("forum-saved", (event) => {
    $("#createForumModal").modal("hide");
    alert(`Forum ${event.detail.title} was ${event.detail.action}!`);
});

window.addEventListener("forum-updated", (event) => {
    $("#editForumModal").modal("hide");
    alert(`Forum ${event.detail.title} was ${event.detail.action}!`);
});


window.addEventListener("chatSaved", (event) => {

});

$(document).on("click", "#selectallmember", function(event) {
    event.preventDefault();
    $("#editChatGroupModal .select2 > option").prop("selected", "selected").trigger("change");
    $("#chatMembers").trigger("change");
    Livewire.emit('chatMembersSelected', $('#chatMembers').select2('val'));
});

$('#chatMembers').on('select2:close', (e) => {
    $("#chatMembers").trigger("change");
    Livewire.emit('chatMembersSelected', $('#chatMembers').select2('val'));
});

window.livewire.on("deleteForumTriggered", (id, name) => {
    const proceed = confirm(`Are you sure you want to delete Forum ${name}`);
    if (proceed) {
        Livewire.emit("destroyForum", id);
        console.log("Ok..emit");
    }
});

Livewire.on("forumDataFetched", (forum) => {
    $("#editForumModal").modal("show");
});