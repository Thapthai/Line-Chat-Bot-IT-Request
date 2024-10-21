require('dotenv').config();
const express = require('express');
const bodyParser = require('body-parser');
const issueRoutes = require('./routes/issueRoutes');
const client = require('@line/bot-sdk').Client({ 
  channelAccessToken: process.env.LINE_ACCESS_TOKEN 
});

const app = express();
app.use(bodyParser.json());
app.use('/api', issueRoutes);

const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
