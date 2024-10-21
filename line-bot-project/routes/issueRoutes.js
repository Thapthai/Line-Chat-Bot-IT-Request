const express = require('express');
const issueController = require('../controllers/issueController');
const router = express.Router();

// เส้นทางสำหรับการจัดการ Line webhook
router.post('/webhook', (req, res) => {
  const events = req.body.events;
  events.forEach((event) => {
    issueController.handleEvent(event, client); // client คือ Line client
  });
  res.status(200).send('OK');
});

module.exports = router;
