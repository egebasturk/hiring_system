import java.sql.*;

public class DBAccess {
    private static Statement statement = null;
    private static ResultSet resultSet = null;

    public static void main(String [] args )
    {
        String encoding = "&useUnicode=yes&characterEncoding=UTF-8";
        encoding = "";
        String localhost = "jdbc:mysql://localhost/project"
                + "?user=root" + encoding;
        try
        {
            Connection connection = DriverManager.getConnection(
                    localhost
            );
            System.out.println("Connected Succesfully");
            statement = connection.createStatement();

            initializeTables();
        }
        catch (SQLException e)
        {
            // do sth maybe
            System.out.println("Cannot connect");
            e.printStackTrace();
        }
    }
    private static void initializeTables()
    {
        createTables();
        insertDummyData();
    }
    public static void insertDummyData()
    {
        try {
            statement.executeUpdate("INSERT INTO services(service_type_ID, service_type_name)" +
                    "values('00001','repair')," +
                    "('00002', 'repair')," +
                    "('00003', 'repair')"
            );
            statement.executeUpdate("INSERT INTO `users` (`user_ID`, `password`, `email`, `username`, `city_name`, `street_number`, `apt_name`, `zip_code`) VALUES ('1', 'admin', 'admin@portakal.com', 'admin', 'xion', '666', 'heckapt', '404');");
            statement.executeUpdate("INSERT INTO `regular_users` (`user_ID`, `name`, `surname`, `date_of_birth`) VALUES ('1', 'adm', 'madm', '2018-05-01');");
            statement.executeUpdate("INSERT INTO `service_orders` (`requester_ID`, `service_type_ID`, `order_details`) VALUES ('1', '1', 'first repair');");
            //statement.executeUpdate("INSERT INTO `has` (`order_ID`, `user_ID`) VALUES ('1', '1');");

        }catch (SQLException e)
        {
            e.printStackTrace();
        }
    }
    private static void createTables()
    {
        try {
            // Order of Drops is IMPORTANT

            statement.executeUpdate("drop table if exists private_lesson;");
            statement.executeUpdate("drop table if exists repair_service;");
            statement.executeUpdate("drop table if exists painting_service;");
            statement.executeUpdate("drop table if exists cleaning_service;");
            statement.executeUpdate("drop table if exists moving_service;");
            statement.executeUpdate("drop table if exists has_taken;");
            statement.executeUpdate("drop table if exists collaborators;");
            statement.executeUpdate("drop table if exists service_ratings_evaluations;");
            statement.executeUpdate("drop table if exists provided;");
            statement.executeUpdate("drop table if exists past_services;");
            //statement.executeUpdate("drop table if exists has;");
            statement.executeUpdate("drop table if exists matches;");
            statement.executeUpdate("drop table if exists service_orders;");
            statement.executeUpdate("drop table if exists provides;");
            statement.executeUpdate("drop table if exists provided_services;");
            statement.executeUpdate("drop table if exists proposed_collaborative_services;");
            statement.executeUpdate("drop table if exists proposals;");
            statement.executeUpdate("drop table if exists proposed_services;");
            statement.executeUpdate("drop table if exists services;");
            statement.executeUpdate("drop table if exists professional_users;");
            statement.executeUpdate("drop table if exists regular_users;");
            statement.executeUpdate("drop table if exists users;");

            statement.executeUpdate("CREATE TABLE users"+
                    "(user_ID INT PRIMARY KEY AUTO_INCREMENT,"+
                    "password VARCHAR(32) NOT NULL,"+
                    "email VARCHAR(32) NOT NULL UNIQUE,"+
                    "username VARCHAR(32) NOT NULL UNIQUE,"+
                    "city_name VARCHAR(32) DEFAULT NULL,"+
                    "street_number VARCHAR(32) DEFAULT NULL,"+
                    "apt_name VARCHAR(32) DEFAULT NULL,"+
                    "zip_code INT DEFAULT NULL" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE regular_users" +
                    "(user_ID INT PRIMARY KEY," +
                    "FOREIGN KEY (user_ID) REFERENCES users( user_ID)" +
                    "ON DELETE CASCADE\n" + // DO NOT DELETE '\n' else it fails
                    "ON UPDATE CASCADE," +
                    "name VARCHAR (32) DEFAULT NULL," +
                    "surname VARCHAR (32) DEFAULT NULL," +
                    "date_of_birth DATE DEFAULT NULL" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE professional_users" +
                    "(user_ID INT PRIMARY KEY," +
                    "FOREIGN KEY (user_ID) REFERENCES users( user_ID)\n" +
                    "ON DELETE CASCADE\n" + // DO NOT DELETE '\n' else it fails
                    "ON UPDATE CASCADE," +
                    "experience INT DEFAULT NULL," +
                    "expertise_field VARCHAR(32) DEFAULT NULL" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE services" +
                    "(service_type_ID INT PRIMARY KEY," +
                    "service_type_name VARCHAR(32) NOT NULL" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE past_services\n" +
                    "(service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES services( service_type_ID)\n" +
                    "ON DELETE CASCADE\n" + // DO NOT DELETE '\n' else it fails
                    "ON UPDATE CASCADE," +
                    "order_date DATE," +
                    "provider_ID INT," +
                    "PRIMARY KEY (service_type_ID, order_date, provider_ID)," +
                    "FOREIGN KEY (provider_ID) REFERENCES professional_users( user_ID)" +
                    "ON DELETE CASCADE\n" + // DO NOT DELETE '\n' else it fails
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE service_orders" +
                    "(order_ID INT PRIMARY KEY AUTO_INCREMENT," +
                    "requester_ID INT," +
                    "service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES services( service_type_ID)\n" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "order_details VARCHAR(128)" +
                    ")engine=InnoDB;"
            );
            /*statement.executeUpdate("CREATE TRIGGER service_trigger " +
                    "AFTER INSERT ON service_orders" +
                    "FOR EACH ROW " +
                    "BEGIN\n" +
                    "INSERT INTO `has` (`order_ID`, `user_ID`)" +
                    " VALUES ( IF(ISNULL(NEW.thread_id), 0, NEW.thread_id, ), NEW.);" +
                    "END;"
            );*/
            statement.executeUpdate("CREATE TABLE proposed_services" +
                    "(proposal_ID INT PRIMARY KEY," +
                    "service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES services( service_type_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "start_date DATE," +
                    "end_date DATE," +
                    "proposed_price INT" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE proposed_collaborative_services" +
                    "(proposal_ID INT PRIMARY KEY," +
                    "FOREIGN KEY (proposal_ID) REFERENCES proposed_services( proposal_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "services VARCHAR(128)" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE provided_services" +
                    "(service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES proposed_services( service_type_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "custom_service_name VARCHAR(32)," +
                    "PRIMARY KEY (service_type_ID, custom_service_name)," +
                    "service_rating INT," +
                    "service_starting_date DATE," +
                    "service_ending_date DATE" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE service_ratings_evaluations" +
                    "(PRIMARY KEY (user_ID, service_type_ID, order_date, provider_ID)," +
                    "user_ID INT," +
                    "FOREIGN KEY (user_ID) REFERENCES regular_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES services( service_type_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "order_date DATE," +
                    "provider_ID INT," +
                    "FOREIGN KEY (provider_ID) REFERENCES professional_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "rating INT," +
                    "evaluation VARCHAR(128)" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE has_taken" +
                    "(PRIMARY KEY (user_ID, service_type_ID, order_date, provider_ID)," +
                    "user_ID INT," +
                    "FOREIGN KEY (user_ID) REFERENCES regular_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES services( service_type_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "order_date DATE," +
                    "provider_ID INT," +
                    "FOREIGN KEY (provider_ID) REFERENCES professional_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE collaborators" +
                    "(proposal_ID INT PRIMARY KEY," +
                    "FOREIGN KEY (proposal_ID) REFERENCES proposed_services( proposal_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "user_ID INT," +
                    "FOREIGN KEY (user_ID) REFERENCES professional_users( user_ID)\n" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE proposals" +
                    "(PRIMARY KEY (professional_ID, proposal_ID)," +
                    "professional_ID INT," +
                    "FOREIGN KEY (professional_ID ) REFERENCES professional_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "proposal_ID INT," +
                    "FOREIGN KEY (proposal_ID) REFERENCES proposed_services( proposal_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            /*statement.executeUpdate("CREATE TABLE has" +
                    "(PRIMARY KEY (order_ID, user_ID)," +
                    "order_ID INT," +
                    "FOREIGN KEY (order_ID) REFERENCES service_orders (order_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "user_ID INT," +
                    "FOREIGN KEY (user_ID) REFERENCES regular_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );*/
            statement.executeUpdate("CREATE TABLE provides" +
                    "(PRIMARY KEY (user_ID, service_type_ID)," +
                    "user_ID INT," +
                    "FOREIGN KEY (user_ID) REFERENCES professional_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "service_type_ID INT," +
                    "custom_service_name VARCHAR (32)," +
                    "FOREIGN KEY (service_type_ID,custom_service_name)  REFERENCES provided_services (service_type_ID,custom_service_name)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            // TODO: Related services is not working
            statement.executeUpdate("CREATE TABLE matches" +
                    "(PRIMARY KEY (order_ID, proposal_ID)," +
                    "order_ID INT," +
                    "FOREIGN KEY (order_ID) REFERENCES service_orders (order_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "proposal_ID INT," +
                    "FOREIGN KEY (proposal_ID) REFERENCES proposals (proposal_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            // TODO: Sub Services (Things at the bottom right) not implemented
            statement.executeUpdate("CREATE TABLE provided" +
                    "(PRIMARY KEY (service_type_ID, order_date, provider_ID)," +
                    "service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES past_services( service_type_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "order_date DATE," +
                    "provider_ID INT," +
                    "FOREIGN KEY (provider_ID) REFERENCES professional_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE private_lesson" +
                    "(PRIMARY KEY (service_type_ID),"+
                    "service_type_ID INT," +
                    "custom_service_name VARCHAR(32)," +
                    "FOREIGN KEY (service_type_ID, custom_service_name) REFERENCES provided_services(service_type_ID, custom_service_name)\n" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "course_type VARCHAR(32)," +
                    "hourly_rate INT," +
                    "frequency VARCHAR(32)" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE repair_service" +
                    "(PRIMARY KEY (service_type_ID),"+
                    "service_type_ID INT," +
                    "custom_service_name VARCHAR(32)," +
                    "FOREIGN KEY (service_type_ID, custom_service_name) REFERENCES provided_services(service_type_ID, custom_service_name)\n" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "base_material_price INT," +
                    "item_type VARCHAR(32)" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE cleaning_service" +
                    "(PRIMARY KEY (service_type_ID)," +
                    "service_type_ID INT," +
                    "custom_service_name VARCHAR(32)," +
                    "FOREIGN KEY (service_type_ID, custom_service_name) REFERENCES provided_services(service_type_ID, custom_service_name)\n" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "base_room_price INT," +
                    "base_bathroom_price INT," +
                    "worker_rate INT," +
                    "frequency VARCHAR(32)" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE painting_service" +
                    "(PRIMARY KEY (service_type_ID)," +
                    "service_type_ID INT," +
                    "custom_service_name VARCHAR(32)," +
                    "FOREIGN KEY (service_type_ID, custom_service_name) REFERENCES provided_services(service_type_ID, custom_service_name)\n" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "total_volume INT," +
                    "color_type VARCHAR(32)," +
                    "number_of_rooms INT" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE moving_service" +
                    "(PRIMARY KEY (service_type_ID, custom_service_name)," +
                    "service_type_ID INT," +
                    "custom_service_name VARCHAR(32)," +
                    "FOREIGN KEY (service_type_ID, custom_service_name) REFERENCES provided_services(service_type_ID, custom_service_name)\n" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "new_city_name VARCHAR(32)," +
                    "new_zip_code INT," +
                    "new_apt_name VARCHAR(32)," +
                    "new_street_number INT," +
                    "city_name VARCHAR(32)," +
                    "zip_code INT," +
                    "apt_name VARCHAR(32)," +
                    "street_number INT" +
                    ")engine=InnoDB;"
            );
            /*
            statement.executeUpdate("INSERT INTO services(service_type_ID, service_type_name)" +
                    "values('00001','repair')," +
                    "('00002', 'repair')," +
                    "('00003', 'repair')"
            );
            statement.executeUpdate("INSERT INTO proposed_services(proposal_ID, service_type_ID, start_date, end_date, proposed_price)" +
                    "values('1','00001', '1985.09.08', '1985.09.09', '40' )," +
                    "('2','00002','1985.02.08', '1985.06.08', '50')," +
                    "('3','00003','1985.01.08', '1985.03.08', '60')"
            );
            statement.executeUpdate("INSERT INTO provided_services(service_type_ID, custom_service_name, service_rating, service_starting_date, service_ending_date)" +
                    "values('00001', 'anan_repair', '5', '1985.09.08', '1985.09.09' )," +
                    "('00002', 'baban_repair', '6', '1985.02.08', '1985.06.08')," +
                    "('00003', 'dayın_repair', '3', '1985.01.08', '1985.03.08')"
            );
            statement.executeUpdate("INSERT INTO repair_service(service_type_ID, custom_service_name, base_material_price, item_type)" +
                    "values('00001', 'anan_repair','10', 'anan')," +
                    "('00002', 'baban_repair', '20', 'baban')," +
                    "('00003', 'dayın_repair', '20', 'dayın')"
            );*/
        }catch (SQLException e)
        {
            e.printStackTrace();
        }
    }
}