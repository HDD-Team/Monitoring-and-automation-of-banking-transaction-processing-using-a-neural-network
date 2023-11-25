from kafka import KafkaProducer, KafkaConsumer

# Создание производителя Kafka
producer = KafkaProducer(bootstrap_servers='localhost:9092')

# Отправка новых транзакций в топик
producer.send('transactions', b'New transaction 1')
producer.send('transactions', b'New transaction 2')
producer.flush()

# Создание потребителя Kafka
consumer = KafkaConsumer('transactions', bootstrap_servers='localhost:9092', group_id='my-group')

# Чтение и обработка новых транзакций из топика
for message in consumer:
    print(message.value)
    # Обработка транзакции

# Закрытие соединения с Kafka
producer.close()
consumer.close()