const Sequelize = require('sequelize');
const db = require('../config/database');

const Email = db.define('v_email', {
    email_id: {
        type: Sequelize.INTEGER,
        allowNull: false,
    },
    open_date: {
        type: Sequelize.DATE,
        allowNull: false,
    },
    subject: {
        type: Sequelize.TEXT,
        allowNull: true,
    },
    content: {
        type: Sequelize.TEXT,
        allowNull: true,
    },
    content_as_is: {
        type: Sequelize.TEXT,
        allowNull: true,
    },
    email: {
        type: Sequelize.STRING,
        allowNull: false,
    },
    attachment: {
        type: Sequelize.STRING,
        allowNull: true,
    },
    type: {
        type: Sequelize.STRING,
        allowNull: true,
    },
    is_read: {
        type: Sequelize.INTEGER,
        allowNull: true,
    }
},
{
    timestamps: false
});

module.exports = Email;
