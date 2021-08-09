Livewire.on("deleteTriggered", (id, name) => {
    const proceed = confirm(`Are you sure you want to delete ${name}`);

    if (proceed) {
        Livewire.emit("destroy", id);
    }
});

window.addEventListener("chat-grpup-deleted", (event) => {
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

window.addEventListener("group-saved", (event) => {
    $("#createChatGroupModal").modal("hide");
    alert(`Chat Group ${event.detail.title} was ${event.detail.action}!`);
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