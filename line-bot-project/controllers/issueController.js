const IssueService = require('../services/issueService');

// เก็บสถานะชั่วคราวระหว่างที่ผู้ใช้แจ้งปัญหา
const currentIssue = {};

const issueController = {
    handleEvent: async (event, client) => {
        const userId = event.source.userId;
        const userMessage = event.message.text;

        if (userMessage.startsWith('แจ้งปัญหา')) {
            const issue = userMessage.replace('แจ้งปัญหา', '').trim();
            currentIssue[userId] = { issue: issue };
            const reply = { type: 'text', text: `รับแจ้งปัญหา: ${issue}\nกรุณาระบุรายละเอียดปัญหา` };
            return client.replyMessage(event.replyToken, reply);

        } else if (userMessage.startsWith('รายละเอียด') && currentIssue[userId]) {
            const details = userMessage.replace('รายละเอียด', '').trim();
            const issue = currentIssue[userId].issue;

            try {
                // ส่งข้อมูลไปยัง Service Layer เพื่อบันทึกในฐานข้อมูล
                await IssueService.createIssue(userId, issue, details);

                const reply = {
                    type: 'text',
                    text: `ปัญหาที่แจ้ง:\n${issue}\nรายละเอียด:\n${details}\n\nระบบได้รับการแจ้งปัญหาของคุณแล้ว ขอบคุณค่ะ!`
                };
                client.replyMessage(event.replyToken, reply);
                delete currentIssue[userId]; // ล้างข้อมูลการแจ้งปัญหาออกหลังจากเสร็จสิ้น
            } catch (error) {
                console.error('Error:', error);
                client.replyMessage(event.replyToken, { type: 'text', text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล' });
            }
        }
    }
};

module.exports = issueController;
