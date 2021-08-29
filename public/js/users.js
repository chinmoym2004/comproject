/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/users.js ***!
  \*******************************/
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _wrapNativeSuper(Class) { var _cache = typeof Map === "function" ? new Map() : undefined; _wrapNativeSuper = function _wrapNativeSuper(Class) { if (Class === null || !_isNativeFunction(Class)) return Class; if (typeof Class !== "function") { throw new TypeError("Super expression must either be null or a function"); } if (typeof _cache !== "undefined") { if (_cache.has(Class)) return _cache.get(Class); _cache.set(Class, Wrapper); } function Wrapper() { return _construct(Class, arguments, _getPrototypeOf(this).constructor); } Wrapper.prototype = Object.create(Class.prototype, { constructor: { value: Wrapper, enumerable: false, writable: true, configurable: true } }); return _setPrototypeOf(Wrapper, Class); }; return _wrapNativeSuper(Class); }

function _construct(Parent, args, Class) { if (_isNativeReflectConstruct()) { _construct = Reflect.construct; } else { _construct = function _construct(Parent, args, Class) { var a = [null]; a.push.apply(a, args); var Constructor = Function.bind.apply(Parent, a); var instance = new Constructor(); if (Class) _setPrototypeOf(instance, Class.prototype); return instance; }; } return _construct.apply(null, arguments); }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

function _isNativeFunction(fn) { return Function.toString.call(fn).indexOf("[native code]") !== -1; }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

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
}); // Livewire.on("forumCreate", () => {
//     console.log("OK");
//     $("#createForumModal").modal("show");
// });

Livewire.on("categoryFetched", function () {
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
window.addEventListener("chatSaved", function (event) {
  //console.log(event.detail);
  chatid = event.detail.data.chat_id;
  $('.chat-history').animate({
    scrollTop: $('.chat-history ul')[0].scrollHeight
  }, "slow");
});
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
/***  Topic ****/

Livewire.on("topicCreate", function () {
  console.log("OK");
  $("#createTopicsModal").modal("show");
});
window.addEventListener("topic-saved", function (event) {
  $("#createTopicsModal").modal("hide");
  alert("Topic ".concat(event.detail.title, " was ").concat(event.detail.action, "!"));
});
Livewire.on("deleteTopicTriggered", function (id, name) {
  var proceed = confirm("Are you sure you want to delete ".concat(name));

  if (proceed) {
    Livewire.emit("destroyTopic", id);
  }
});
window.addEventListener("topic-deleted", function (event) {
  alert("".concat(event.detail.title, " was deleted!"));
});
Livewire.on("topicDataFetched", function (forum) {
  $("#editTopicModal").modal("show");
});
window.addEventListener("topic-updated", function (event) {
  $("#editTopicModal").modal("hide");
  alert("Topic ".concat(event.detail.title, " was ").concat(event.detail.action, "!"));
}); //chat-box-open

/***  Circular ****/

Livewire.on("circularCreate", function () {
  console.log("OK");
  $("#createcircularModal").modal("show");
});
window.addEventListener("circular-saved", function (event) {
  $("#createcircularModal").modal("hide");
  alert("circular ".concat(event.detail.title, " was ").concat(event.detail.action, "!"));
});
Livewire.on("deletecircularTriggered", function (id, name) {
  var proceed = confirm("Are you sure you want to delete ".concat(name));

  if (proceed) {
    Livewire.emit("destroycircular", id);
  }
});
window.addEventListener("circular-deleted", function (event) {
  alert("".concat(event.detail.title, " was deleted!"));
});
Livewire.on("circularDataFetched", function (forum) {
  $("#editcircularModal").modal("show");
});
window.addEventListener("circular-updated", function (event) {
  $("#editcircularModal").modal("hide"); //$('.modal-backdrop').remove();

  alert("circular ".concat(event.detail.title, " was ").concat(event.detail.action, "!"));
});
/****1-1 chat** */

window.addEventListener("chat-box-open", function (event) {
  window.location.href = "".concat(event.detail.redirect_to);
});
window.addEventListener("openSearch", function (event) {
  $("#usersearchModal").modal("show");
});
window.addEventListener("chatloaded", function (event) {
  $('.chat-history').animate({
    scrollTop: $('.chat-history ul')[0].scrollHeight
  }, "slow");
});
window.addEventListener("chatMembersloaded", function (event) {
  console.log(event);
  $("#viewchatMembersModal").modal("show");
});
window.addEventListener("upoadFile", function (event) {
  $("#viewUploadFileModal").modal("show");
});
/**** Group *****/

Livewire.on("groupCreate", function () {
  $("#creategroupModal").modal("show");
});
window.addEventListener("group-saved", function (event) {
  $("#creategroupModal").modal("hide");
  alert("group ".concat(event.detail.title, " was ").concat(event.detail.action, "!"));
});
Livewire.on("deletegroupTriggered", function (id, name) {
  var proceed = confirm("Are you sure you want to delete ".concat(name));

  if (proceed) {
    Livewire.emit("destroygroup", id);
  }
});
window.addEventListener("group-deleted", function (event) {
  alert("".concat(event.detail.title, " was deleted!"));
});
Livewire.on("groupDataFetched", function (forum) {
  $("#editgroupModal").modal("show");
});
Livewire.on("groupMemberDataFetched", function (forum) {
  $("#groupMemberUpdateModal").modal("show");
});
window.addEventListener("group-updated", function (event) {
  $("#editgroupModal").modal("hide");
  alert("group ".concat(event.detail.title, " was ").concat(event.detail.action, "!"));
});
window.addEventListener('memberUpdated', function (event) {
  $("#groupMemberUpdateModal").modal("hide");
  $('.modal-backdrop').remove();
});
window.addEventListener('memberRemoved', function (event) {
  $("#member_" + event.detail.id).remove();
}); // window.addEventListener("memberSelectedFromSearch", (event) => {
//     console.log(event.detail.id);
//     console.log(event.detail.text);
//     Livewire.emit("selectedFromSearch", event.detail.id, event.detail.text);
// });

Livewire.on("categoryCreate", function () {
  $("#categoryModel").modal("show");
});
window.addEventListener("category-saved", function (event) {
  $("#categoryModel").modal("hide");
});
Livewire.on("deleteCategoryTriggered", function (id, name) {
  var proceed = confirm("Are you sure you want to delete ".concat(name));

  if (proceed) {
    Livewire.emit("destroyCategory", id);
  }
});
Livewire.on("catDataFetched", function (forum) {
  $("#updatecategoryModel").modal("show");
});
window.addEventListener("category-updated", function (event) {
  $("#updatecategoryModel").modal("hide");
});
/****** LOCAL TIME *****/

var LocalTimeElement = /*#__PURE__*/function (_HTMLElement) {
  _inherits(LocalTimeElement, _HTMLElement);

  var _super = _createSuper(LocalTimeElement);

  function LocalTimeElement() {
    _classCallCheck(this, LocalTimeElement);

    return _super.apply(this, arguments);
  }

  _createClass(LocalTimeElement, [{
    key: "connectedCallback",
    value: function connectedCallback() {
      var date = new Date(this.attributes.getNamedItem('datetime').value);
      var language = document.querySelector('html').getAttribute('lang');
      var format = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric'
      };
      this.innerText = date.toLocaleString(language, format);
    }
  }, {
    key: "attributeChangedCallback",
    value: function attributeChangedCallback() {
      this.connectedCallback();
    }
  }], [{
    key: "observedAttributes",
    get: function get() {
      return ['datetime'];
    }
  }]);

  return LocalTimeElement;
}( /*#__PURE__*/_wrapNativeSuper(HTMLElement));

customElements.define('local-time', LocalTimeElement);
window.livewire.hook('element.initialized', function (el) {
  if (!el.tagName.includes("-")) {
    return;
  }

  el.__livewire_ignore = true;
});
window.livewire.hook('element.updating', function (fromEl, toEl, component) {
  if (!fromEl.tagName.includes("-")) {
    return;
  }

  for (var i = 0, atts = toEl.attributes, n = atts.length, arr = []; i < n; i++) {
    fromEl.setAttribute(atts[i].nodeName, atts[i].nodeValue);
  }
});
/******/ })()
;