import ApplicationService from "@/services/ApplicationService";

class AuthService extends ApplicationService {
  resource = "/admin/auth";

  //* **************************************************** *//

  async login(data) {
    return await this.post(`${this.resource}/login`, data);
  }

  async logout(data) {
    return await this.post(`${this.resource}/logout`, data);
  }

  async updateProfile(data) {
    return await this.put(`${this.resource}/profile`, data);
  }

  async forgetPassword(data) {
    return await this.post(`${this.resource}/forget-password`, data);
  }

  async resetPassword(data) {
    return await this.post(`${this.resource}/reset-password`, data);
  }

  async updatePassword(data) {
    return await this.put(`${this.resource}/profile/change-password`, data);
  }

  //* **************************************************** *//
}
export default new AuthService();
