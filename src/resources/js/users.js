const { set } = require("lodash");

Livewire.on("deleteTriggered", (id, name) => {
    const proceed = confirm(`Are you sure you want to delete ${name}`);
    if (proceed) {
        Livewire.emit("destroy", id);
    }
});

window.addEventListener("chat-grpup-deleted", (event) => {
    //alert(`${event.detail.title} was deleted!`);
});

window.addEventListener("forum-deleted", (event) => {
    //alert(`${event.detail.title} was deleted!`);
});

Livewire.on("triggerCreate", () => {
    Livewire.emit("fetchGroupForChargroup");
});

window.addEventListener("groupdataFetchedForChat", (event) => {
    $("#createChatGroupModal").modal("show");
});

Livewire.on("dataFetched", (chat) => {
    console.log(chat);
    $("#editChatGroupModal").modal("show");
});

// Livewire.on("forumCreate", () => {
//     console.log("OK");
//     $("#createForumModal").modal("show");
// });

Livewire.on("categoryFetched", () => {
    $("#createForumModal").modal("show");
});



window.addEventListener("group-saved", (event) => {
    $("#createChatGroupModal").modal("hide");
    //alert(`Chat Group ${event.detail.title} was ${event.detail.action}!`);
});

window.addEventListener("forum-saved", (event) => {
    $("#createForumModal").modal("hide");
    $('.modal-backdrop').remove();
    //alert(`Forum ${event.detail.title} was ${event.detail.action}!`);
});

window.addEventListener("forum-updated", (event) => {
    $("#editForumModal").modal("hide");
    //alert(`Forum ${event.detail.title} was ${event.detail.action}!`);
});


window.addEventListener("chatSaved", (event) => {
    //console.log(event.detail);
    chatid = event.detail.data.chat_id;

    $('.chat-history').animate({
        scrollTop: $('.chat-history ul')[0].scrollHeight
    }, "slow");

    if ($("#page-content").length) {
        $('#page-content').animate({
            scrollTop: $('#page-content .media-chat')[0].scrollHeight
        }, "slow");
    }
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

/***  Topic ****/

Livewire.on("topicCreate", () => {
    console.log("OK");
    $("#createTopicsModal").modal("show");
});
Livewire.on("userTopicCreate", () => {
    console.log("OK");
    $("#createTopicsModal").modal("show");
});

window.addEventListener("usercommented", (event) => {
    console.log("OK commentCreated");
    Livewire.emit("commentCreated");
});

window.addEventListener("subcommented", (event) => {
    $(".comment .newreply").addClass("d-none");
});
window.addEventListener("topic-saved", (event) => {
    $("#createTopicsModal").modal("hide");
    //alert(`Topic ${event.detail.title} was ${event.detail.action}!`);
});

window.addEventListener("circularDataFetched", (event) => {
    $("#viewCircularModal").modal("show");
});

Livewire.on("deleteTopicTriggered", (id, name) => {
    const proceed = confirm(`Are you sure you want to delete ${name}`);
    if (proceed) {
        Livewire.emit("destroyTopic", id);
    }
});

window.addEventListener("topic-deleted", (event) => {
    // alert(`${event.detail.title} was deleted!`);
});

Livewire.on("topicDataFetched", (forum) => {
    $("#editTopicModal").modal("show");
});

window.addEventListener("topic-updated", (event) => {
    $("#editTopicModal").modal("hide");
    //alert(`Topic ${event.detail.title} was ${event.detail.action}!`);
});

//chat-box-open

/***  Circular ****/

Livewire.on("fetchedGroupForCircular", () => {
    $("#createcircularModal").modal("show");
    $("#createcircularModal .select2").select2();
});

window.addEventListener("circular-saved", (event) => {
    $("#createcircularModal").modal("hide");
    //alert(`circular ${event.detail.title} was ${event.detail.action}!`);
});

Livewire.on("deletecircularTriggered", (id, name) => {
    const proceed = confirm(`Are you sure you want to delete ${name}`);
    if (proceed) {
        Livewire.emit("destroycircular", id);
    }
});

window.addEventListener("circular-deleted", (event) => {
    //alert(`${event.detail.title} was deleted!`);
});

Livewire.on("circularDataFetched", (forum) => {
    $("#editcircularModal").modal("show");
});

window.addEventListener("circular-updated", (event) => {
    $("#editcircularModal").modal("hide");
    //$('.modal-backdrop').remove();
    //alert(`circular ${event.detail.title} was ${event.detail.action}!`);
});

/****1-1 chat** */

window.addEventListener("chat-box-open", (event) => {
    window.location.href = `${event.detail.redirect_to}`;
});

window.addEventListener("openSearch", (event) => {
    $("#usersearchModal").modal("show");
});

window.addEventListener("chatloaded", (event) => {
    $('.chat-history').animate({
        scrollTop: $('.chat-history ul')[0].scrollHeight
    }, "slow");
});

window.addEventListener("chatMembersloaded", (event) => {
    console.log(event);
    $("#viewchatMembersModal").modal("show");
});

window.addEventListener("upoadFile", (event) => {
    $("#viewUploadFileModal").modal("show");
});


$(document).on("click", "#openFileupload", function(event) {
    $("#files").trigger("click");
});
/**** Group *****/

Livewire.on("groupCreate", () => {
    $("#creategroupModal").modal("show");
});

window.addEventListener("group-saved", (event) => {
    $("#creategroupModal").modal("hide");
    //alert(`group ${event.detail.title} was ${event.detail.action}!`);
});

Livewire.on("deletegroupTriggered", (id, name) => {
    const proceed = confirm(`Are you sure you want to delete ${name}`);
    if (proceed) {
        Livewire.emit("destroygroup", id);
    }
});

window.addEventListener("group-deleted", (event) => {
    //alert(`${event.detail.title} was deleted!`);
});

Livewire.on("groupDataFetched", (forum) => {
    $("#editgroupModal").modal("show");
});

Livewire.on("groupMemberDataFetched", (forum) => {
    $("#groupMemberUpdateModal").modal("show");
});

window.addEventListener("group-updated", (event) => {
    $("#editgroupModal").modal("hide");
    //alert(`group ${event.detail.title} was ${event.detail.action}!`);
});

window.addEventListener('memberUpdated', (event) => {
    $("#groupMemberUpdateModal").modal("hide");
    $('.modal-backdrop').remove();
});

window.addEventListener('memberRemoved', (event) => {
    $("#member_" + event.detail.id).remove();
});


// window.addEventListener("memberSelectedFromSearch", (event) => {
//     console.log(event.detail.id);
//     console.log(event.detail.text);
//     Livewire.emit("selectedFromSearch", event.detail.id, event.detail.text);
// });



Livewire.on("categoryCreate", () => {
    $("#categoryModel").modal("show");
});

window.addEventListener("category-saved", (event) => {
    $("#categoryModel").modal("hide");
});

Livewire.on("deleteCategoryTriggered", (id, name) => {
    const proceed = confirm(`Are you sure you want to delete ${name}`);
    if (proceed) {
        Livewire.emit("destroyCategory", id);
    }
});

Livewire.on("catDataFetched", (forum) => {
    $("#updatecategoryModel").modal("show");
});

window.addEventListener("category-updated", (event) => {
    $("#updatecategoryModel").modal("hide");
});


// Livewire.on("setSeelct2", () => {
//     $(".select2").select2();
// });

window.addEventListener("chatMemberDataFetched", (event) => {
    console.log("Ok");
    $("#chatMemberUpdateModal").modal("show");
});

/****** LOCAL TIME *****/

class LocalTimeElement extends HTMLElement {
    static get observedAttributes() {
        return ['datetime'];
    }

    connectedCallback() {
        var date = new Date(this.attributes.getNamedItem('datetime').value);
        var language = document.querySelector('html').getAttribute('lang');

        var format = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };

        this.innerText = date.toLocaleString(language, format);
    }

    attributeChangedCallback() {
        this.connectedCallback();
    }
}
customElements.define('local-time', LocalTimeElement);

window.livewire.hook('element.initialized', el => {
    if (!el.tagName.includes("-")) {
        return;
    }

    el.__livewire_ignore = true;
})

window.livewire.hook('element.updating', (fromEl, toEl, component) => {
    if (!fromEl.tagName.includes("-")) {
        return;
    }

    for (var i = 0, atts = toEl.attributes, n = atts.length, arr = []; i < n; i++) {
        fromEl.setAttribute(atts[i].nodeName, atts[i].nodeValue);
    }
});