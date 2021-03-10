from Bio import SeqIO
import pandas as pd
import argparse
from tensorflow import keras
from tensorflow.keras.preprocessing.sequence import pad_sequences
import pickle
import numpy as np


# ANALYZES ARGUMENTS
def make_argument_parser():
	parser = argparse.ArgumentParser(description='NCYPred')

	parser.add_argument('-i', required=True, help='input file path', metavar='file input')
	parser.add_argument('-o', required=True, help='output file name', metavar='file output')

	return parser


# REMOVE SEQUENCES WITH UNALLOWED CHARACTERS
def remove(df):
	for i in range(len(df.seq)):
		for j in ['N', 'Y', 'K', 'W', 'R', 'H', 'M', 'S', 'D', 'V', 'B']:
			if j in df.seq[i]:
				df = df.drop(index=i)
				break

	df = df.reset_index(drop=True)
	return df


# DECOMPOSE SEQUENCE INTO 3-MER
def seq_to_3mer(seq_list):
	print('PROCESSING {} SEQUENCES'.format(len(seq_list)))

	main_list = []

	for _, i in enumerate(seq_list):
		seq = list(i)
		seq_kmer = []

		for j, _ in enumerate(seq):
			if j < len(seq) - 2:
				seq_kmer.append(seq[j] + seq[j+1] + seq[j+2])
			else:
				continue

		main_list.append(seq_kmer)

	return main_list


# TOKENIZATION AND ZERO-PADDING
def token_pad(sentences, max_len, prefix):
	print('ZERO-PADDING SEQUENCES TO {} AND TOKENIZING'.format(max_len))

	with open('./tokenize.pickle', 'rb') as handle:
		tokenizer = pickle.load(handle)

	tokens = tokenizer.texts_to_sequences(sentences)
	all_pad = pad_sequences(tokens, max_len, padding=prefix)

	return all_pad


# CONVERT ARGMAX INTO A DICTIONARY
def argmax_to_label(predictions):
	label_list = ['5.8S-rRNA', '5S-rRNA', 'CD-box', 'HACA-box', 'Intron-gp-I', 'Intron-gp-II', 'Leader', 'Riboswitch', 'Ribozyme', 'Y-RNA', 'Y-RNA-like', 'miRNA ', 'tRNA']

	argmax_pred = np.argmax(predictions, axis=1)
	argmax_values = range(13)
	pred_labels = []

	for i in argmax_pred:
		for j, k in zip(argmax_values, label_list):
			if i == j:
				pred_labels.append(k)

	return pred_labels, label_list


# MAIN METHOD
def main():
	parser = make_argument_parser()
	args = parser.parse_args()

	# READ INPUT WITH BIOPYTHON
	input_file = args.i
	output_file = args.o

	# DATAFRAME TO STORE DATA
	df = pd.DataFrame()

	input_id, input_seq = [], []

	for seq_record in SeqIO.parse(input_file, 'fasta'):
		input_id.append(seq_record.id)

		if 'U' in seq_record.seq:
			dna_seq = seq_record.seq.back_transcribe()
			input_seq.append(dna_seq.upper())

		else:
			input_seq.append(seq_record.seq.upper())

	df['id'] = input_id
	df['seq'] = input_seq

	# REMOVE SEQUENCES WITH UNALLOWED CHARACTERS
	df = remove(df)

	# DECOMPOSE SEQUENCE INTO 3-MERS
	x = df['seq']
	x = seq_to_3mer(x)

	# TOKENIZATION AND ZERO-PADDING
	x_pad = token_pad(x, 498, 'post')

	# LOAD MODEL
	print('LOADING MODEL...')
	model = keras.models.load_model('./trained-model/', compile=False)
	print('PREDICTING...')
	predictions = model.predict(x_pad, verbose=0)
	pred_labels, label_list = argmax_to_label(predictions)

	df['prediction'] = pred_labels
	df_softmax = pd.DataFrame(data=predictions, columns=label_list)
	df_final = pd.concat([df, df_softmax], axis=1)
	print('DONE.')

	# SAVE OUTPUT
	print('SAVING RESULTS...')
	df_final.to_csv('./{}.csv'.format(output_file), sep=';', float_format='%.3f')


# CALL OF THE MAIN METHOD
if __name__ == '__main__':
	main()