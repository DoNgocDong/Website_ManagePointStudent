const SERVICE_ACCESS_TOKEN_KEY = "access_token";
const SESSION_USERNAME = "username";

const state = {
  accessToken: localStorage.getItem(SERVICE_ACCESS_TOKEN_KEY) || undefined,
  username: localStorage.getItem(SESSION_USERNAME) || undefined,
}

function request() {
  const accessToken = state.accessToken;
  const headers = {};
  
  if(accessToken) {
    headers.Authorization = state.accessToken;
  }

  return axios.create({
    headers: headers
  });
}

function setSession(accessToken) {
  let username = null;
  try {
    username = atob(accessToken);
  } catch (error) {
    username = null;
  }

  state.accessToken = accessToken;
  state.username = username;

  localStorage.setItem(SERVICE_ACCESS_TOKEN_KEY, accessToken);
  localStorage.setItem(SESSION_USERNAME, username);
}

function removeSession() {
  state.accessToken = undefined;
  state.username = undefined;
  
  localStorage.removeItem(SERVICE_ACCESS_TOKEN_KEY);
  localStorage.removeItem(SESSION_USERNAME);
}

function getUsername() {
  return state.username;
}

function logout() {
  removeSession();
  location.href = "/";
}

function login() {
  location.href = "/auth/login";
}

function changePass() {
  location.href = "/auth/change-password";
}

const username = getUsername();
const userDropdown = document.getElementById('user-dropdown');
const loginBtn = document.getElementById('login');
const changePassBtn = document.getElementById('changePass');
const logoutBtn = document.getElementById('logout');

if (username) {
  userDropdown.textContent = `${username}`;
  loginBtn.style.display = 'none';
} else {
  userDropdown.textContent = 'Guest';
  changePassBtn.style.display = 'none';
  logoutBtn.style.display = 'none';
}