const Issue = require('../models/issue');

class IssueService {
    // ฟังก์ชันสำหรับบันทึกข้อมูลปัญหา
    static async createIssue(userId, issue, details) {
        try {
            const newIssue = await Issue.create({
                userId,
                issue,
                details,
            });
            return newIssue;
        } catch (error) {
            throw new Error('Error saving issue to database');
        }
    }
}

module.exports = IssueService;
