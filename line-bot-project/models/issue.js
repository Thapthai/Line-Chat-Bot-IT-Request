const { DataTypes } = require('sequelize');
const sequelize = require('../config/database');

const Issue = sequelize.define('Issue', {
    userId: {
        type: DataTypes.STRING,
        allowNull: false
    },
    issue: {
        type: DataTypes.STRING,
        allowNull: false
    },
    details: {
        type: DataTypes.TEXT,
        allowNull: false
    }
});

module.exports = Issue;
