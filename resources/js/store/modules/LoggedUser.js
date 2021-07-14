const state = {
    Akun: {
      Id_Akun: null,
      Id_Karyawan:null,
      Username: null,
      Name: null,
      Divisi: null,
      Jabatan:null,
      Akses:null,
    },
  
    isLoggedIn: false,
  };
  
  const mutations = {
    setLoggedUser (state, source) {
      state.Akun.Id_Akun = source.Id_Akun
      state.Akun.Id_Karyawan = source.Id_Karyawan
      state.Akun.Name = source.Name
      state.Akun.Username = source.Username
      state.Akun.Divisi = source.Divisi
      state.Akun.Jabatan = source.Jabatan
      state.Akun.Akses = source.Akses

      state.isLoggedIn = true
    },
  
    loggedOut (state) {
      state.isLoggedIn = false
    }
  }
  
  const getters = {
    Id_Akun: state => state.Akun.Id_Akun,
    Id_Karyawan: state => state.Akun.Id_Karyawan,
    Name: state => state.Akun.Name,
    Username: state => state.Akun.Username,
    Divisi: state => state.Akun.Divisi,
    Jabatan: state=> state.Akun.Jabatan,
    Akses: state=> state.Akun.Akses

  }
  
  export default {
    namespaced: true,
    state,
    mutations,
    getters
  };